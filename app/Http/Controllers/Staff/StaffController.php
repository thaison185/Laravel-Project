<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicStaff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = AcademicStaff::query();

        $staff = $staff->paginate(10);
        return view('staff.staff.index',[
            'staff' => $staff,
            'focus' => 'staff',
        ]);
    }
}
