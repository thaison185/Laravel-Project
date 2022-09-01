<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AcademicStaff extends Authenticatable
{
    use HasFactory;
    protected $table = 'academic_staff';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'avatar',
        'role',
    ];
}
