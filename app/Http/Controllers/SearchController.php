<?php

namespace App\Http\Controllers;

use App\Models\AcademicStaff;
use App\Models\Classs;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Major;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        if ($search != '') {
            $lecturers = Lecturer::where(function ($query) use ($search) {
                $query->where(DB::raw('BINARY `id`'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('BINARY `name`'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('BINARY `email`'), 'like', '%' . $search . '%');
            })->get();
            $students = Student::where(function ($query) use ($search) {
                $query->where(DB::raw('BINARY `id`'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('BINARY `name`'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('BINARY `email`'), 'like', '%' . $search . '%');
            })->get();
            $staff = AcademicStaff::where(function ($query) use ($search) {
                $query->where(DB::raw('BINARY `id`'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('BINARY `name`'), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw('BINARY `email`'), 'like', '%' . $search . '%');
            })->get();
            return response()->json([
                'lecturers'=>$lecturers,
                'students'=>$students,
                'staff'=>$staff,
                'status'=>'success'
            ]);
        }
        return response()->json([
            'status'=>'empty'
        ]);
    }
}
