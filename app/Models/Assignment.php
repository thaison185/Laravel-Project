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
        'subject_id',
        'lecturer_id',
        'semester',
    ];

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }
}
