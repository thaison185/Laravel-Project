<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('test',function (){return view('test');});
Route::redirect('/','/login');
Route::get('login/{role?}',[LoginController::class,'show'])->name('login');
Route::post('login',[LoginController::class,'authenticate'])->name('login-handler');
Route::get('logout',[LoginController::class,'logout'])->name('logout');

Route::prefix('student')->middleware('auth:student')->name('student.')->group(function (){
    Route::get('home',function (){
        return view('welcome');
    })->name('home');
});

Route::prefix('staff')->middleware('auth:staff')->name('staff.')->group(function (){
    Route::get('home',function (){
        return view('staff.home');
    })->name('home');
});

Route::prefix('lecturer')->middleware('auth:lecturer')->name('lecturer.')->group(function (){
    Route::get('home',function (){
        return view('welcome');
    })->name('home');
});

