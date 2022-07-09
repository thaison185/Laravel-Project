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
}
