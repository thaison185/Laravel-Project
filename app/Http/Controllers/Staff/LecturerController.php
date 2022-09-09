<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\LecturerAssignmentRequest;
use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Imports\LecturersImport;
use App\Models\Assignment;
use App\Models\Classs;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Major;
use App\Models\MajorSubject;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class LecturerController extends Controller
{
    private $faculties;

    public function __construct(){
        $this->faculties = Faculty::all();
        View::share('faculties', $this->faculties);
    }

    public function index(Request $request){
        $lecturers = Lecturer::query();
        $filter = '';
        if($request->has('faculty')){
            $filter = $request->get('faculty');
            if($filter!='') $lecturers = $lecturers->where('faculty_id',$filter);
        }
        if ($request->has('search')){
            $search = $request->get('search');
            if($search!=''){
                $lecturers = $lecturers->where(function($query) use($search){
                    $query->where('id','like','%'.$search.'%')
                        ->orWhere('name','like','%'.$search.'%')
                        ->orWhere('email','like','%'.$search.'%');
                });
            }
        }
        $lecturers = $lecturers->with('faculty')->paginate(12);
        return view('staff.lecturers.index',[
            'lecturers' => $lecturers,
            'filter' => $filter,
            'focus' => 'lecturers'
        ]);
    }

    public function create(){
        return view('staff.lecturers.add',['focus'=>'add-lecturer']);
    }

    public function store(StoreLecturerRequest $request){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        $infos['description'] = $request->get('description');
        $infos['degree'] = $request->get('degree');
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
            $avatar = Storage::putFile('/lecturers',$infos['avatar']);
            $infos['avatar'] = $avatar;
        }
        $infos['password']=Hash::make($infos['password']);

        $infos['DoB'] = Carbon::createFromFormat('d/m/Y',$infos['DoB']);
        if(Carbon::tomorrow()->diffInYears($infos['DoB']) < 22){
            return response()->json([
                'status' => 'error',
                'message' => 'The new Lecturer has to be at least 22 years old!',
            ]);
        }
        $infos['DoB']->toDateString();
        try{
            $lecturer = Lecturer::create($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'New lecturer has been added successfully!',
        ]);
    }

    public function importIndex(){
        return view('staff.lecturers.import',['focus'=>'import-lecturers']);
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
            $import = new LecturersImport($extension);
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
                            if(Carbon::tomorrow()->diffInYears($dob) < 22){
                                $onFailure('New Lecturers have to be more than 22 years old');
                            }
                        }
                    ],
                    'faculty_id' => ['required','exists:App\Models\Faculty,id'],
                    'title' => ['max:15'],
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
                $import = new LecturersImport($extension);
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
        $lecturer = Lecturer::with('assignments.majorSubject.subject')->find($id);
        $subjectClass = [];
        if($lecturer->subjects()!==null) {
            foreach ($lecturer->subjects() as $each){
                $name = Subject::find($each->subject_id);
                $majorSubjects = MajorSubject::where('subject_id',$each->subject_id)->get();
                $assignments= Assignment::with(['classs','majorSubject.major'])->whereIn('major-subject_id',$majorSubjects->modelKeys())->get();
                $subjectClass[] =['name'=>$name,'assignments'=>$assignments];
            }
        }
        $allMajors = Major::where('faculty_id',$lecturer->faculty_id)->get();
        $allClasses = Classs::with('major')->whereIn('major_id',$allMajors->modelKeys())->get();
        $allMajorSubjects = MajorSubject::with(['subject','major'])->whereIn('major_id',$allMajors->modelKeys())->orderBy('subject_id')->get();
        return view('staff.lecturers.profile',[
            'lecturer' => $lecturer,
            'focus' => 'lecturers',
            'subjectClass' => $subjectClass,
            'allMajors' => $allMajors,
            'allMajorSubjects' => $allMajorSubjects,
            'allClasses'=>$allClasses,
        ]);
    }

    public function update(UpdateLecturerRequest $request, $id){
        try {
            $data = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Lecturer::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Can't find Lecturer ID=".$id,
            ]);
        }

        $type = $request->get('type');
        if ($type === 'basic'){
            $data['degree'] = $request->get('degree');
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
            $data['DoB'] = Carbon::createFromFormat('d/m/Y',$data['DoB']);
            if(Carbon::tomorrow()->diffInYears($data['DoB']) < 22){
                return response()->json([
                    'status' => 'error',
                    'message' => 'The new Lecturer has to be at least 22 years old!',
                ]);
            }
            $data['DoB']->toDateString();
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
            $avatar = Storage::putFile('/lecturers',$data['avatar']);
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
        try{$target = Lecturer::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Staff ID=".$id." doesn't exist!",
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
            'message' => 'Lecturer ID='.$id." deleted!",
        ];
    }

    public function assignment(LecturerAssignmentRequest $request,$id){
        try{
            $data = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$lecturer = Lecturer::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Can't find Lecturer ID=".$id,
            ]);
        }

        $allMajors = Major::where('faculty_id',$lecturer->faculty_id)->get();
        if(!$allMajors->contains('id',$data['major_id']))
            return response()->json([
            'status' => 'error',
            'message' => "Major is invalid",
        ]);

        $allClasses = Classs::where('major_id',$data['major_id'])->get();
        if(!$allClasses->contains('id',$data['class_id']))
            return response()->json([
                'status' => 'error',
                'message' => "Class is invalid",
            ]);

        $allMajorSubjects = MajorSubject::where('major_id',$data['major_id'])->get();
        if(!$allMajorSubjects->contains('subject_id',$data['subject_id']))
            return response()->json([
                'status' => 'error',
                'message' => "Subject is invalid",
            ]);

        if(!$allMajorSubjects->where('subject_id',$data['subject_id'])->contains('semester',$data['semester']))
            return response()->json([
                'status' => 'error',
                'message' => "Semester is invalid",
            ]);
        $majorSubject = MajorSubject::where(['major_id'=>$data['major_id'],'subject_id'=>$data['subject_id'],'semester'=>$data['semester']])->first()->id;
        try{
            Assignment::create([
                'lecturer_id'=>$id,
                'class_id'=>$data['class_id'],
                'major-subject_id'=>$majorSubject,
            ]);
        }catch (\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Assignment created!',
        ]);
    }
}
