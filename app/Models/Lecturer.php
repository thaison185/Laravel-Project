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
