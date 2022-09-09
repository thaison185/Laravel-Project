<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicPerformance;
use App\Models\Student;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function show($student){
        $student = Student::with(['performances','classs.assignments'])->find($student);
        return view('staff.performance.show',['student'=>$student,'focus'=>'performances']);
    }
}
