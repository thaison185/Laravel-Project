<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\MajorRequest;
use App\Http\Requests\SubjectMajorRequest;
use App\Http\Requests\SubjectRequest;
use App\Models\Classs;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\MajorSubject;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class SubjectMajorController extends Controller
{
    private $faculties;
    private $subjects;
    private $majors;

    public function __construct()
    {
        $this->faculties = Faculty::all();
        $this->subjects = Subject::all();
        $this->majors = Major::all();
        View::share('faculties', $this->faculties);
        View::share('subjects', $this->subjects);
        View::share('majors', $this->majors);
    }

    public function subjects()
    {
        $subjects = Subject::query();

        $subjects = $subjects->paginate(10);
        return view('staff.subject-major.subjects',['subjects'=>$subjects,'focus' => 'subjects']);
    }

    public function updateSubject(SubjectRequest $request, $id){
        try {
            $data = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Subject::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Can't find Subject ID=".$id,
            ]);
        }
        if(Str::length($data['name'])>50){
            return response()->json([
                'status' => 'error',
                'message' => 'The total length of name cannot exceed 50 characters!',
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
            'message' => 'Subject has been updated successfully!',
        ]);
    }

    public function storeSubject(SubjectRequest $request){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        if(Str::length($infos['name'])>50){
            return response()->json([
                'status' => 'error',
                'message' => 'The total length of name cannot exceed 50 characters!',
            ]);
        }
        $infos['description'] = $request->get('description');
        try{
            $staff = Subject::create($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'New subject has been added successfully!',
        ]);
    }

    public function deleteSubject(DeleteRequest $request, $id){
        try {
            $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Subject::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Subject ID=".$id." doesn't exist!",
            ]);
        }
        if($request->get('type')==='force'){
            try{
                MajorSubject::where('subject_id',$id)->delete();
            }catch(\Throwable $exception){
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ]);
            }
        }
        else{
            if (MajorSubject::where('subject_id',$id)->count()!==0){
                return response()->json([
                    'status' => 'error',
                    'action' => 'close',
                    'message' => 'This subject is in some curriculums. If you want to delete all related records of this subject, use FORCE DELETE!',
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
            'message' => 'Subject ID='.$id." deleted!",
        ];
    }

    public function majors()
    {
        $majors = Major::query();
        $majors = $majors->with(['faculty','majorSubject','subject'])->paginate(10);
        return view('staff.subject-major.majors',['majors'=>$majors,'focus' => 'majors']);
    }

    public function updateMajor(MajorRequest $request, $id){
        try {
            $data = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Major::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Can't find Major ID=".$id,
            ]);
        }
        if(Str::length($data['name'])>50){
            return response()->json([
                'status' => 'error',
                'message' => 'The total length of name cannot exceed 50 characters!',
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
            'message' => 'Staff has been updated successfully!',
        ]);
    }

    public function storeMajor(MajorRequest $request){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        if(Str::length($infos['name'])>50){
            return response()->json([
                'status' => 'error',
                'message' => 'The total length of name cannot exceed 50 characters!',
            ]);
        }
        $infos['description'] = $request->get('description');
        try{
            $staff = Major::create($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'New major has been added successfully!',
        ]);
    }

    public function deleteMajor(DeleteRequest $request, $id){
        try {
            $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = Major::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Major ID=".$id." doesn't exist!",
            ]);
        }
        if(Classs::where('major_id',$id)->count()===0 && MajorSubject::where('major_id',$id)->count()===0){
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
                'message' => 'Major ID='.$id." deleted!",
            ];
        }
        return response()->json([
            'status' => 'error',
            'message' => "You need to delete all subjects and classes belong to this Major before delete it!",
        ]);
    }

    public function addSubjectMajor(SubjectMajorRequest $request){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{
            $target = MajorSubject::create($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'New subject has been added successfully!',
        ]);
    }

    public function deleteSubjectMajor(DeleteRequest $request, $major, $subject, $semester){
        try {
            $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = MajorSubject::where(['major_id'=>$major,'subject_id'=>$subject,'semester'=>$semester]);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Trying to delete non-exist record!",
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
            'message' => 'Subject deleted!',
        ];
    }
}
