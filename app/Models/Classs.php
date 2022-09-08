<?php

namespace App\Models;

use Database\Factories\ClassFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classs extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return ClassFactory::new();
    }
    protected $table = 'classes';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'admission_year',
        'major_id',
    ];

    public function major(){
        return $this->belongsTo(Major::class);
    }

    public function students(){
        return $this->hasMany(Student::class,'class_id','id');
    }

    public function assignments(){
        return $this->hasMany(Assignment::class,'class_id','id');
    }

    public function assignment($majorSubject){
        return $this->assignments->where('major-subject_id',$majorSubject)->first();
    }
}
