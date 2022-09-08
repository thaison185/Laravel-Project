<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Major extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function majorSubject(){
        return $this->hasMany(MajorSubject::class);
    }

    public function subject(){
        return $this->hasManyThrough(
            Subject::class,
            MajorSubject::class,
            'major_id',
            'id',
            'id',
            'subject_id',
        );
    }

    protected $fillable = [
        'name',
        'description',
        'degree',
        'faculty_id',
    ];

    public function semester(){
        $semester = [8,10,4,8];
        return $semester[$this->degree];
    }

    public function inSemester($semester){
        $inSemester = $this->majorSubject->where('semester',$semester);
        $return = [];
        foreach ($inSemester as $subject){
            $return[] = ['subject'=>$subject->subject,'hour'=>$subject->lecture_hour];
        }
        return collect($return);
    }
}
