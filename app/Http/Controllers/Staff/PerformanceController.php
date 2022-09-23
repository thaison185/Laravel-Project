<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicPerformance;
use App\Models\Classs;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function show($student){
        $student = Student::with(['performances','classs.assignments'])->find($student);
        return view('staff.performance.show',['student'=>$student,'focus'=>'performances']);
    }

    public function all($target,$id = null){
        if($target=='faculty' && $id!=null){
            $faculty = Faculty::find($id);
            $majors = Major::where('faculty_id',$id)->paginate(20);
            return view('staff.performance.index',['type' => 'faculty','faculty'=>$faculty,'majors'=>$majors,'focus'=>'performances']);
        }
        if($target=='major' && $id!=null){
            $major = Major::with(['faculty','subject'])->find($id);
            $classes = Classs::where('major_id',$id)->paginate(20);
            return view('staff.performance.index',['type' => 'major','major'=>$major,'classes'=>$classes,'focus'=>'performances']);
        }
        if($target=='class' && $id!=null){
            $class = Classs::with('major.faculty')->find($id);
            $students = Student::where('class_id',$id)->paginate(15);
            return view('staff.performance.index',['type' => 'class','class'=>$class,'students'=>$students,'focus'=>'performances']);
        }
        $faculties = Faculty::paginate(20);
        return view('staff.performance.index',['type' => 'all','faculties'=>$faculties,'focus'=>'performances']);
    }

    public function analyze($target,$id=null){
        if($target=='faculty' && $id!=null){
            $majors = Major::where('faculty_id',$id)->get();
            $classes = Classs::whereIn('major_id',$majors->modelKeys())->get();
            $students = Student::with(['classs.major','performances'])->whereIn('class_id',$classes->modelKeys())->get();
            $total = $students->count();
            $studentsEachMajor = [];
            foreach($majors as $major){
                $classesEach = $classes->where('major_id',$major->id);
                $failed = 0;
                $studentsEach = $students->whereIn('class_id',$classesEach->modelKeys());
                foreach ($studentsEach as $student){
                    for($semester=1;$semester<=10;$semester++){
                        if($student->status($semester)==-1) {$failed++; break;}
                    }
                }
                $studentsEachMajor[] = ['title'=>$major->name,'total'=>$students->whereIn('class_id',$classesEach->modelKeys())->count(),'failed'=>$failed];
            }
            return response()->json([
                'total'=>$total,
                'data' => $studentsEachMajor,
            ]);
        }
        if($target=='major' && $id!=null){
            $major = Major::with('majorSubject.subject')->find($id);
            $classes = Classs::where('major_id',$id)->get();
            $students = Student::with(['classs.major','performances'])->whereIn('class_id',$classes->modelKeys())->get();
            $total = $students->count();
            $studentsEachClass = [];
            $semesters = $major->semester();
            foreach($classes as $class){
                $statusBySemester=[];
                $studentsEach = $students->where('class_id',$class->id);
                for($semester=1;$semester<=$semesters;$semester++){
                    $failedTotal = 0;
                    $passedTotal = 0;
                    $inProcessTotal = 0;
                    $subjects = $major->inSemester($semester);
                    $statusBySubject=[];
                    foreach($subjects as $each){
                        $failed = 0;
                        $passed = 0;
                        $inProcess = 0;
                        $name = Subject::find($each->subject_id)->name;
                        foreach ($studentsEach as $student){
                            switch($student->status($semester,$each->subject_id)){
                                case(-1):
                                    $failed++;
                                    break;
                                case(0):
                                    $inProcess++;
                                    break;
                                case(1):
                                    $passed++;
                                    break;
                            }
                        }
                        $statusBySubject[]=['name'=>$name,'failed'=>$failed,'inProcess'=>$inProcess,'passed'=>$passed];
                    }
                    foreach ($studentsEach as $student){
                        switch($student->status($semester)){
                            case(-1):
                                $failedTotal++;
                                break;
                            case(0):
                                $inProcessTotal++;
                                break;
                            case(1):
                                $passedTotal++;
                                break;
                        }
                    }
                    if($passedTotal==0&&$inProcessTotal==0&&$failedTotal==0) $statusBySemester[]=['No Information'];
                    else $statusBySemester[] = ['failed'=>$failedTotal,'passed'=>$passedTotal,'inProcess'=>$inProcessTotal,'bySubject'=>$statusBySubject];
            }
                $studentsEachClass[] = ['title'=>$class->name,'total'=>$studentsEach->count(),'status'=>$statusBySemester];
            }
            return response()->json([
                'total'=>$total,
                'data' => $studentsEachClass,
            ]);
        }
        if($target=='class' && $id!=null){
            $major = Classs::find($id)->major;
            $students = Student::with(['classs.major','performances'])->where('class_id',$id)->get();
            $total = $students->count();
            $semesters = $major->semester();
            $statusBySemester=[];
            for($semester=1;$semester<=$semesters;$semester++){
                $failedTotal = 0;
                $passedTotal = 0;
                $inProcessTotal = 0;
                $subjects = $major->inSemester($semester);
                $statusBySubject=[];
                foreach($subjects as $each){
                    $failed = 0;
                    $passed = 0;
                    $inProcess = 0;
                    $name = Subject::find($each->subject_id)->name;
                    foreach ($students as $student){
                        switch($student->status($semester,$each->subject_id)){
                            case(-1):
                                $failed++;
                                break;
                            case(0):
                                $inProcess++;
                                break;
                            case(1):
                                $passed++;
                                break;
                        }
                    }
                    $statusBySubject[]=['name'=>$name,'failed'=>$failed,'inProcess'=>$inProcess,'passed'=>$passed];
                }
                foreach ($students as $student){
                    switch($student->status($semester)){
                        case(-1):
                            $failedTotal++;
                            break;
                        case(0):
                            $inProcessTotal++;
                            break;
                        case(1):
                            $passedTotal++;
                            break;
                    }
                }
                if($passedTotal==0&&$inProcessTotal==0&&$failedTotal==0) $statusBySemester[]=['No Information'];
                else $statusBySemester[] = ['semester'=>$semester,'failed'=>$failedTotal,'passed'=>$passedTotal,'inProcess'=>$inProcessTotal,'bySubject'=>$statusBySubject];
            }
            return response()->json([
                'total'=>$total,
                'status'=>$statusBySemester,
            ]);
        }
        $faculties = Faculty::all();
        $students = Student::all();
        $studentsEachFaculty = [];
        foreach($faculties as $faculty){
            $majorsEach = Major::where('faculty_id',$faculty->id)->get();
            $classesEach = Classs::whereIn('major_id',$majorsEach->modelKeys())->get();
            $failed = 0;
            $studentsEach = $students->whereIn('class_id',$classesEach->modelKeys());
            foreach ($studentsEach as $student){
                for($semester=1;$semester<=10;$semester++){
                    if($student->status($semester)==-1) {$failed++; break;}
                }
            }
            $studentsEachFaculty[] = ['title'=>$faculty->name,'total'=>$students->whereIn('class_id',$classesEach->modelKeys())->count(),'failed'=>$failed];
        }
        return response()->json([
            'total'=>$students->count(),
            'data' => $studentsEachFaculty,
        ]);
    }
}
