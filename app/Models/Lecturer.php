<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Lecturer extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function assignments(){
        return $this->hasMany(Assignment::class);
    }

    public function majorSubjects(){
        return $this->hasManyThrough(MajorSubject::class,Assignment::class,'lecturer_id','id','id','major-subject_id');
    }

    public function subjects(){
        if(!$this->majorSubjects->isEmpty()) return $this->majorSubjects->toQuery()->distinct()->get('subject_id');
        return null;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'DoB',
        'gender',
        'avatar',
        'title',
        'degree',
        'description',
        'faculty_id',
    ];
}
