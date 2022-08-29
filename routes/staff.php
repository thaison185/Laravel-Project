<?php

use Illuminate\Support\Facades\Route;

Route::get('/index',function (){
    return view('staff.home');
})->name('home');

Route::get('lecturers',function (){
    return view('staff.lecturers');
})->name('lecturers');
