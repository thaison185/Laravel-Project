<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    protected function classes(){
        return $this->hasManyThrough(Classs::class,Major::class);
    }

}
