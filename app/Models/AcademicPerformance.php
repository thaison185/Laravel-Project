<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicPerformance extends Model
{
    use HasFactory;
    protected $table = 'academic_performance';
    public $timestamps = false;

    public function assignment(){
        return $this->belongsTo(Assignment::class,'assignment_id','id');
    }
}
