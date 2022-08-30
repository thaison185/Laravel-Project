<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Staff\LecturerController;
use App\Http\Controllers\Staff\StudentController;
use App\Http\Controllers\Staff\StaffController;
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
// [-------------------------------AUTH ROUTES-------------------------------]
Route::redirect('/','/login');
Route::get('login/{role?}',[LoginController::class,'show'])->name('login');
Route::post('login',[LoginController::class,'authenticate'])->name('login-handler');
Route::get('logout',[LoginController::class,'logout'])->name('logout');


// [-------------------------------STUDENT ROUTES-------------------------------]
Route::prefix('student')->middleware('auth:student')->name('student.')->group(function (){
    Route::get('home',function (){
        return view('welcome');
    })->name('home');
});


// [-------------------------------STAFF ROUTES-------------------------------]
Route::prefix('staff')->middleware('auth:staff')->name('staff.')->group(function (){
    Route::get('home',function (){
        return view('staff.home',['focus'=>'home-tag']);
    })->name('home');

    Route::group([
        'as' => 'lecturers.',
        'prefix' => 'lecturers',
    ], static function(){
        Route::match(['get','post'],'/',[LecturerController::class,'index'])->name('all');
        Route::get('/{id}',[LecturerController::class,'profile'])->where('id', '[0-9]+')->name('one');
        Route::get('/add',[LecturerController::class,'create'])->name('create');
        Route::post('/add',[LecturerController::class,'store'])->name('store');
        Route::post('/{id}/update',[LecturerController::class,'update'])->name('update');
        Route::get('import',[LecturerController::class,'importIndex'])->name('import-index');
        Route::post('import',[LecturerController::class,'import'])->name('import');
    });

    Route::group([
        'as' => 'students.',
        'prefix' => 'students',
    ], static function(){
        Route::match(['get','post'],'/',[StudentController::class,'index'])->name('all');
        Route::get('/{id}',[StudentController::class,'profile'])->where('id', '[0-9]+')->name('one');
        Route::get('/add',[StudentController::class,'create'])->name('create');
        Route::post('/add',[StudentController::class,'store'])->name('store');
        Route::post('/{id}/update',[StudentController::class,'update'])->name('update');
        Route::get('import',[StudentController::class,'importIndex'])->name('import-index');
        Route::post('import',[StudentController::class,'import'])->name('import');
    });

    Route::group([
        'as' => 'staff.',
        'prefix' => 'staff',
    ], static function(){
        Route::match(['get','post'],'/',[StaffController::class,'index'])->name('all');
        Route::get('/{id}',[StaffController::class,'profile'])->where('id', '[0-9]+')->name('one');
        Route::get('/add',[StaffController::class,'create'])->name('create');
        Route::post('/add',[StaffController::class,'store'])->name('store');
        Route::post('/{id}/update',[StaffController::class,'update'])->name('update');
    });
});


// [-------------------------------LECTURER ROUTES-------------------------------]
Route::prefix('lecturer')->middleware('auth:lecturer')->name('lecturer.')->group(function (){
    Route::get('home',function (){
        return view('welcome');
    })->name('home');
});

