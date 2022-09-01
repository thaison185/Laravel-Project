<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\AcademicStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function update(StaffRequest $request, $id){
        try {
            $data = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        try{$target = AcademicStaff::find($id);}
        catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => "Can't find Staff ID=".$id,
            ]);
        }
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
        if(!empty($data['avatar'])) {
            $data['avatar'] = Storage::putFile('/students', $data['avatar']);
        }
        if(!empty($data['new-pass'])) {
            $data['password'] = Hash::make($data['new-pass']);
        }
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

    public function store(StaffRequest $request){
        try {
            $infos = $request->validated();
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
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
        $infos['password']=Hash::make($infos['new-pass']);
        try{
            $staff = AcademicStaff::create($infos);
        }catch(\Throwable $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'New staff has been added successfully!',
        ]);
    }
}
