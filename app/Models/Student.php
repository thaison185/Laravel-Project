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

    public function status($semester,$subject=null){
        $assignments = $this->assignmentsInSemester($semester);
        if($subject!=null){
            $majorSubjects = MajorSubject::where('subject_id',$subject)->get();
            $assignments = $assignments->whereIn('major-subject_id',$majorSubjects->modelKeys());
        }else{if($assignments->isEmpty()) return -2;}
        foreach($assignments as $assignment){
            if($this->performance($assignment->id) == null) return 0;
            if($this->performance($assignment->id)->score < 6) return -1;
        }
        return 1;
    }

    public function average($semester=null){
        $assignments = $this->assignmentsInSemester($semester);
    }
}
