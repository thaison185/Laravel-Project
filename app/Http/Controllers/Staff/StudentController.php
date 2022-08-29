<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Classs;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    private $faculties;
    private $classes;

    public function __construct()
    {
        $this->faculties = Faculty::all();
        $this->classes = Classs::all();
        View::share('faculties', $this->faculties);
        View::share('classes', $this->classes);
    }

    public function index(Request $request)
    {
        $students = Student::query();
        $filter=['faculty'=>'','class'=>''];
        if($request->has('faculty'))
        {
            $filter['faculty'] = $request->get('faculty');
            if(!empty($filter['faculty']))
            {
                $this->classes = Classs::where('faculty_id',$filter['faculty'])->get(); //TODO: implement through Majors (use relationship)
                $students = $students->whereIn('class_id',$this->classes->modelKeys());
            }
        }
        if($request->has('class'))
        {
            $filter['class'] = $request->get('class');
            if(!empty($filter['class'])) $students = $students->where('class_id',$filter['class']);
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
        $students = $students->paginate(18);
        return view('staff.students.index',[
            'students' => $students,
            'filter' => $filter,
            'focus' => 'students'
        ]);
    }
}
