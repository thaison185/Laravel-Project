<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Staff\FacultyClassController;
use App\Http\Controllers\Staff\LecturerController;
use App\Http\Controllers\Staff\StudentController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\SubjectMajorController;
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
        Route::post('{id}/delete',[LecturerController::class,'delete'])->name('delete');
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
        Route::post('{id}/delete',[StudentController::class,'delete'])->name('delete');
    });

    Route::group([
        'as' => 'staff.',
        'prefix' => 'staff',
    ], static function(){
        Route::get('/',[StaffController::class,'index'])->name('all');
        Route::get('/add',[StaffController::class,'create'])->name('create');
        Route::post('/add',[StaffController::class,'store'])->name('store');
        Route::post('/{id}/update',[StaffController::class,'update'])->name('update');
        Route::post('{id}/delete',[StaffController::class,'delete'])->name('delete');
    });

    Route::group([
        'as' => 'staff.',
        'prefix' => 'staff',
    ], static function(){
        Route::get('/',[StaffController::class,'index'])->name('all');
        Route::post('/add',[StaffController::class,'store'])->name('store');
        Route::post('/{id}/update',[StaffController::class,'update'])->name('update');
        Route::post('{id}/delete',[StaffController::class,'delete'])->name('delete');
    });

    Route::group([
        'as' => 'subject-major.',
        'prefix' => 'subject-major',
    ], static function(){
        Route::get('/subjects',[SubjectMajorController::class,'subjects'])->name('subjects');
        Route::get('/majors',[SubjectMajorController::class,'majors'])->name('majors');
        Route::post('/subject/add',[SubjectMajorController::class,'storeSubject'])->name('storeSubject');
        Route::post('/subject/{id}/update',[SubjectMajorController::class,'updateSubject'])->name('updateSubject');
        Route::post('/subject/{id}/delete',[SubjectMajorController::class,'deleteSubject'])->name('deleteSubject');
        Route::post('/major/add',[SubjectMajorController::class,'storeMajor'])->name('storeMajor');
        Route::post('/major/{id}/update',[SubjectMajorController::class,'updateMajor'])->name('updateMajor');
        Route::post('/major/{id}/delete',[SubjectMajorController::class,'deleteMajor'])->name('deleteMajor');
        Route::post('/add-subject-major',[SubjectMajorController::class,'addSubjectMajor'])->name('addSubjectMajor');
        Route::post('/{major}/{subject}/{semester}/delete',[SubjectMajorController::class,'deleteSubjectMajor'])->name('deleteSubjectMajor');
    });

    Route::group([
        'as' => 'faculty-class.',
        'prefix' => 'faculty-class',
    ], static function(){
        Route::get('/faculties',[FacultyClassController::class,'faculties'])->name('faculties');
        Route::get('/classes',[FacultyClassController::class,'classes'])->name('classes');
        Route::post('/faculties/add',[FacultyClassController::class,'storeFaculty'])->name('storeFaculty');
        Route::post('/faculty/{id}/update',[FacultyClassController::class,'updateFaculty'])->name('updateFaculty');
        Route::post('/faculty/{id}/delete',[FacultyClassController::class,'deleteFaculty'])->name('deleteFaculty');
        Route::post('/class/add',[FacultyClassController::class,'storeClass'])->name('storeClass');
        Route::post('/class/{id}/update',[FacultyClassController::class,'updateClass'])->name('updateClass');
        Route::post('/class/{id}/delete',[FacultyClassController::class,'deleteClass'])->name('deleteClass');
        Route::get('/class/{id}/subjects',[FacultyClassController::class,'subjects'])->name('subjects');
        Route::post('/class/{id}/assignment',[FacultyClassController::class,'assignment'])->name('assignment');
    });


});


// [-------------------------------LECTURER ROUTES-------------------------------]
Route::prefix('lecturer')->middleware('auth:lecturer')->name('lecturer.')->group(function (){
    Route::get('home',function (){
        return view('welcome');
    })->name('home');
});

