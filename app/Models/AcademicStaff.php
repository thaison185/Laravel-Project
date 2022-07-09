<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicStaff extends Model
{
    use HasFactory;
    protected $table = 'academic_staff';
    public $timestamps = false;
}
