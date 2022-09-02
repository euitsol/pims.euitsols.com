<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\departmentController;
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

Route::get('/test', function(){
    return view('test');
});


Route::get('/', [HomeController::class, 'index'])->name('home');


Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    // Users management
    Route::get('/view', [UserController::class, 'index'])->name('users.index');
    Route::get('/add', [UserController::class, 'add'])->name('users.add');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');

    //Role
    Route::get('/roles/view', [UserController::class, 'role_index'])->name('users.role.index');
    Route::get('/roles/add', [UserController::class, 'role_add'])->name('users.role.add');
    Route::post('/roles/store', [UserController::class, 'role_store'])->name('users.role.store');

    //Permission
    Route::get('/permission/add', [UserController::class, 'permission_add'])->name('users.permission.add');
    Route::post('/permission/store', [UserController::class, 'permission_store'])->name('users.permission.store');


    // Route ::::::::::::::::: Noibr :::::::::::::::::::
    Route::resource('departments', departmentController::class);
    Route::resource('classRoom', 'ClassRoomController');
    Route::resource('notice', 'noticeController');
    Route::resource('teachers', 'TeacherController');
    Route::resource('userCreation', 'userCreationController');
    Route::resource('semester_details', 'semesterDetailsController');
    Route::resource('semester', 'semesterController');
    Route::resource('routine', 'routineController');
    Route::resource('assignment', 'assignmentController');
    Route::resource('userRollCreation', 'userRollController');
    Route::resource('manus', 'menusController');
    Route::post('assignmentSubmit', 'assignmentController@assignmentSubmit')->name('assignmentSubmit');      
    Route::get('Admission_std_show', 'admissionPromotController@Admission_std_show')->name('students.Admission_std_show');
    Route::put('Admission_std_promotion', 'admissionPromotController@Admission_std_promotion')->name('students.Admission_std_promotion');
    Route::post('Admission_std_assign', 'admissionPromotController@Admission_std_assign')->name('students.Admission_std_assign');

});
