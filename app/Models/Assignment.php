<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table='lecturer-subject-class';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'class_id',
        'major-subject_id',
        'lecturer_id',
    ];

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }

    public function majorSubject(){
        return $this->belongsTo(MajorSubject::class,'major-subject_id','id');
    }

    public function semester(){
        return $this->majorSubject->semester;
    }

    public function classs(){
        return $this->belongsTo(Classs::class,'class_id','id');
    }
}
