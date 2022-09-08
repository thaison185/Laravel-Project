<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Imports\StudentImport;
use App\Models\Classs;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    private $faculties;
    private $classes;
    private $majors;

    public function __construct()
    {
        $this->faculties = Faculty::all();
        $this->classes = Classs::all();
        $this->majors = Major::all();
        View::share('faculties', $this->faculties);
        View::share('classes', $this->classes);
        View::share('majors', $this->majors);
    }

    public function index(Request $request)
    {
        $students = Student::query();
        $filter=[
            'faculty'=>$request->get('faculty'),
            'class'=>$request->get('class'),
            'major'=>$request->get('major'),
        ];
        if(!empty($filter['class'])) $students = $students->where('class_id',$filter['class']);
        else if(!empty($filter['major']))
        {
            $classes = Classs::where('major_id',$filter['major'])->get();
            $students = $students->whereIn('class_id',$classes->modelKeys());
        }
        else if(!empty($filter['faculty']))
        {
            $majors = Major::where('faculty_id',$filter['faculty'])->get();
            $classes = Classs::whereIn('major_id',$majors->modelKeys());
            $students = $students->whereIn('class_id',$classes->modelKeys());
        }
        if ($request->has('search'))
        {
            $search = $request->get('search');
            if($search!='')
            {
                $students = $students->where(function($query) use($search)
                {
                    $query->where('id','like','%'.$search.'%')
                        ->orWhere('name','like','%'.$search.'%')
                        ->orWhere('email','like','%'.$search.'%');
                });
            }
        }
        $students = $students->with(['classs.major'])->paginate(18);
        return view('staff.students.index',[
            'students' => $students,
            'filter' => $filter,
            'focus' => 'students'
        ]);
    }

    public function create(){
        return view('staff.students.add',['focus'=>'add-student']);
    }

    public function store(StoreStudentRequest $request){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        $infos['description'] = $request->get('description');
        $name = $infos['last-name'].' '.$infos['first-name'];
        unset($infos['first-name']);
        unset($infos['last-name']);
        $infos['name'] = $name;
        if(Str::length($infos['name'])>30){
            return response()->json([
                'status' => 'error',
                'message' => 'The total length of full name cannot exceed 30 characters!',
            ]);
        }
        if(!empty($infos['avatar'])){
            $avatar = Storage::putFile('/students',$infos['avatar']);
            $infos['avatar'] = $avatar;
        }
        $infos['password']=Hash::make($infos['password']);

        $infos['phone'] = explode(' ',$infos['phone'])[1];

        $infos['DoB'] = Carbon::createFromFormat('d/m/Y',$infos['DoB'])->toDateString();
        try{
            $student = Student::create($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'New student has been added successfully!',
        ]);
    }

    public function importIndex(){
        return view('staff.students.import',['focus'=>'import-students']);
    }

    public function import(ImportRequest $request){
        try {
            $safe = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }

        $extension = $request->file('file')->extension();
        if ($safe['type']==='preview'){
            $import = new StudentImport($extension);
            $data=$import->toCollection($request->file('file'))[0];
            $errors = [];
            foreach($data as $key=>$row){
                $validator = Validator::make($row->toArray(), [
                    'name' => ['required','max:30','regex:/^[A-Z][a-zA-Z ]{1,}$/'],
                    'email' => ['required','email'],
                    'password' => ['required','min:8'],
                    'gender' => ['required','in:0,1'],
                    'dob' => [
                        'required',
                        'date',
                        function($attribute,$value,$onFailure){
                            $dob = Carbon::createFromTimestamp(strtotime($value));
                            if(Carbon::tomorrow()->diffInYears($dob) < 17){
                                $onFailure('New Students have to be more than 18 years old');
                            }
                        }
                    ],
                    'class_id' => ['required','exists:App\Models\Classs,id'],
                    'phone' => ['required'],
                ])->errors();
                $errors[$key]=$validator;
            }
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'fails' => $errors,
            ]);
        }
        else {
            try{
                $import = new StudentImport($extension);
                $import->import($request->file('file'));
            }catch(\Throwable $exception){
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ]);
            }
            return response()->json([
                'status' => 'success',
                'fails' => $import->failures(),
                'errors' => $import->errors(),
                'count' => $import->getSuccessRow(),
            ]);

        }
    }

    public function profile($id){
        $student = Student::find($id);
        return view('staff.students.profile',[
            'student' => $student,
            'focus' => 'students',
        ]);
    }

    public function update(StoreStudentRequest $request, $id){
        try {
            $data = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Student::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Can't find Staff ID=".$id,
            ]);
        }

        $type = $request->get('type');
        if ($type === 'basic'){
            $data['description'] = $request->get('description');
            $name = $data['last-name'].' '.$data['first-name'];
            unset($data['first-name']);
            unset($data['last-name']);
            if ($target->name !== $name){
                $data['name'] = $name;
                if(Str::length($data['name'])>30){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'The total length of full name cannot exceed 30 characters!',
                    ]);
                }
            }
            $data['phone'] = explode(' ',$data['phone'])[1];
            $data['DoB'] = Carbon::createFromFormat('d/m/Y',$data['DoB'])->toDateString();
            try{
                $target->update($data);
            }catch(\Throwable $exception){
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Basic information has been updated successfully!',
            ]);
        }
        if($type === 'avatar'){
            $avatar = Storage::putFile('/students',$data['avatar']);
            try{
                $target->update(['avatar'=>$avatar]);
            }catch(\Throwable $exception){
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Avatar has been updated!',
                'avatar' => $avatar,
            ]);
        }
        $new = Hash::make($data['new-pass']);
        try{
            $target->update(['password'=>$new]);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Password has been updated successfully!',
        ]);
    }

    public function delete(DeleteRequest $request, $id){
        try {
            $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Student::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Student ID=".$id." doesn't exist!",
            ]);
        }
        try{
            $target->delete();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return [
            'status' => 'success',
            'message' => 'Student ID='.$id." deleted!",
        ];
    }
}
