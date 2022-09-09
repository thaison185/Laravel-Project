<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\ClassRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\FacultyRequest;
use App\Models\Assignment;
use App\Models\Classs;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Major;
use App\Models\MajorSubject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class FacultyClassController extends Controller
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

    public function faculties()
    {
        $faculties = Faculty::query();
        $faculties = $faculties->paginate(10);
        return view('staff.faculty-class.faculties',['faculties'=>$faculties,'focus' => 'faculties']);
    }

    public function storeFaculty(FacultyRequest $request){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        if(Str::length($infos['name'])>30){
            return response()->json([
                'status' => 'error',
                'message' => 'The total length of name cannot exceed 30 characters!',
            ]);
        }
        $infos['description'] = $request->get('description');
        try{
            $faculty = Faculty::create($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'New faculty has been added successfully!',
        ]);
    }

    public function updateFaculty(FacultyRequest $request, $id){
        try {
            $data = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Faculty::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Can't find Faculty ID=".$id,
            ]);
        }
        if(Str::length($data['name'])>30){
            return response()->json([
                'status' => 'error',
                'message' => 'The total length of name cannot exceed 30 characters!',
            ]);
        }
        $data['description']=$request->get('description');
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
            'message' => 'Faculty has been updated successfully!',
        ]);
    }

    public function deleteFaculty(DeleteRequest $request, $id){
        try {
            $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Faculty::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Faculty ID=".$id." doesn't exist!",
            ]);
        }
        if(Major::where('faculty_id',$id)->count()===0 && Lecturer::where('faculty_id',$id)->count()===0){
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
                'message' => 'Faculty ID='.$id." deleted!",
            ];
        }
        return response()->json([
            'status' => 'error',
            'message' => "You need to delete all lecturers and major belong to this faculty before delete it!",
        ]);
    }

    public function classes()
    {
        $classes = Classs::query();
        $classes = $classes->with(['students','major'])->paginate(10);
        return view('staff.faculty-class.classes',['classes'=>$classes,'focus' => 'classes']);
    }

    public function storeClass(ClassRequest $request){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        $year = substr($infos['admission_year'],-2,2);
        $faculty = Major::find($infos['major_id'])->faculty_id;
        $infos['name']= (($faculty<10)?'0'.$faculty:$faculty) . ((intval($infos['major_id'])<10)?'0'.$infos['major_id']:$infos['major_id']) . $year;
        $like = Classs::select('name')->where('name','like','%'.$infos['name'].'%')->get();
        $class = 0;
        foreach($like as $each){
            $no = substr($each['name'],-2,2);
            if($class<intval($no)) $class = intval($no);
        }
        $class = ($class+1<10)?'0'.($class+1):$class+1;
        $infos['name']=$infos['name'].$class;

        try{
            $class = Classs::create($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Class created with name: '.$infos['name'],
        ]);
    }

    public function updateClass(ClassRequest $request,$id){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Classs::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Can't find Class ID=".$id,
            ]);
        }

        $year = substr($infos['admission_year'],-2,2);
        $faculty = Major::find($infos['major_id'])->faculty_id;
        $infos['name']= (($faculty<10)?'0'.$faculty:$faculty) . ((intval($infos['major_id'])<10)?'0'.$infos['major_id']:$infos['major_id']) . $year;
        $like = Classs::select('name')->where('name','like','%'.$infos['name'].'%')->get();
        $class = 0;
        foreach($like as $each){
            $no = substr($each['name'],-2,2);
            if($class<intval($no)) $class = intval($no);
        }
        $class = ($class+1<10)?'0'.($class+1):$class+1;
        $infos['name']=$infos['name'].$class;

        try{
            $target->update($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Class has been updated successfully!',
        ]);
    }

    public function deleteClass(DeleteRequest $request, $id){
        try {
            $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Classs::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Class ID=".$id." doesn't exist!",
            ]);
        }

        if($request->get('type')==='force'){
            try{
                Student::where('class_id',$id)->delete();
            }catch(\Throwable $exception){
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ]);
            }
        }
        else{
            if (Student::where('class_id',$id)->count()!==0){
                return response()->json([
                    'status' => 'error',
                    'action' => 'close',
                    'message' => 'This class is not empty. If you want to delete all students in this class, use FORCE DELETE!',
                ]);
            }
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
            'message' => 'Class ID='.$id." deleted!",
        ];
    }

    public function subjects($id){
        $class = Classs::with('assignments')->find($id);
        $faculty = $class->major->faculty->id;
        $lecturers = Lecturer::where('faculty_id',$faculty)->get();
        return view('staff.faculty-class.subjects',['class'=>$class,'focus'=>'classes','lecturers'=>$lecturers]);
    }

    public function assignment(AssignmentRequest $request,$id){
        try {
            $data = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        $major_id = Classs::find($id)->major_id;
        $majorSubject = MajorSubject::where(['major_id'=>$major_id,'subject_id' => $data['subject_id'], 'semester' => $data['semester']])->first()->id;
        try {
            Assignment::updateOrCreate(
                ['class_id' => $id, 'major-subject_id' => $majorSubject],
                ['lecturer_id' => $data['lecturer_id']]
            );
        }
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return [
            'status' => 'success',
            'message' => "Assignment has been updated!",
        ];
    }
}
