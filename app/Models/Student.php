<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'DoB',
        'phone',
        'gender',
        'avatar',
        'notification',
        'description',
        'class_id',
    ];

    public function classs(){
        return $this->belongsTo(Classs::class,'class_id');
    }

    public function major(){
        return $this->classs->major();
    }

    public function performances(){
        return $this->hasMany(AcademicPerformance::class);
    }

    public function performance($assignment){
        return $this->performances->where('assignment_id',$assignment)->first();
    }

    public function assignmentsInSemester($semester){
        $return = [];
        foreach($this->classs->assignments as $each){
            if ($each->semester() === $semester){
                $return[] = $each;
            }
        }
        return collect($return);
    }
}
