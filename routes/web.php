<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\setup\EAdmissionController;
use App\Http\Controllers\setup\BoardController;
use App\Http\Controllers\setup\SemesterController;


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

Route::get('/clear-cache', function(){
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::group(['as' => 'users.', 'prefix' => 'users'], function() {

        // Users management
        Route::get('/view', [UserController::class, 'index'])->name('index');
        Route::get('/add', [UserController::class, 'add'])->name('add');
        Route::post('/add-store', [UserController::class, 'store'])->name('store');
        Route::get('/details/{id}', [UserController::class, 'details'])->name('details');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/edit-store', [UserController::class, 'edit_store'])->name('edit.store');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');

        //Role
        Route::get('/roles/view', [UserController::class, 'role_index'])->name('role.index');
        Route::get('/roles/add', [UserController::class, 'role_add'])->name('role.add');
        Route::post('/roles/store', [UserController::class, 'role_store'])->name('role.store');
        Route::get('/roles/details/{id}', [UserController::class, 'role_details'])->name('role.details');
        Route::get('/roles/edit/{id}', [UserController::class, 'role_edit'])->name('role.edit');
        Route::post('roles/edit-store', [UserController::class, 'role_edit_store'])->name('role.edit.store');
        Route::get('roles/delete/{id}', [UserController::class, 'role_delete'])->name('role.delete');

        //Permission
        Route::get('/permission/view', [UserController::class, 'permission_view'])->name('users.permission.view');
        Route::get('/permission/add', [UserController::class, 'permission_add'])->name('users.permission.add');
        Route::post('/permission/store', [UserController::class, 'permission_store'])->name('users.permission.store');
        Route::get('/permission/view', [UserController::class, 'permission_view'])->name('permission.index');
        Route::get('/permission/add', [UserController::class, 'permission_add'])->name('permission.add');
        Route::post('/permission/store', [UserController::class, 'permission_store'])->name('permission.store');
        Route::get('/permission/details/{id}', [UserController::class, 'permission_details'])->name('permission.details');
        Route::get('/permission/edit/{id}', [UserController::class, 'permission_edit'])->name('permission.edit');
        Route::post('/permission/edit-store', [UserController::class, 'permission_edit_store'])->name('permission.edit.store');
        Route::get('/permission/delete/{id}', [UserController::class, 'permission_delete'])->name('permission.delete');
    });

    //department Module
    Route::resource('department', departmentController::class);
    Route::resource('student-admit', studentAdmitcontroller::class);

    // Exam name for admission
    Route::resource('exam-name-admission', EAdmissionController::class);

    // Board
    Route::resource('board', BoardController::class);

    //Semester
    Route::group(['as' => 'semester.', 'prefix' => 'semester'], function() {
        Route::get('/view', [SemesterController::class, 'index'])->name('index');
        Route::get('/add', [SemesterController::class, 'add'])->name('add');
        Route::post('/add-store', [SemesterController::class, 'store'])->name('store');
        Route::get('/details/{id}', [SemesterController::class, 'details'])->name('details');
        Route::get('/edit/{id}', [SemesterController::class, 'edit'])->name('edit');
        Route::post('/edit-store', [SemesterController::class, 'edit_store'])->name('edit.store');
        Route::get('/delete/{id}', [SemesterController::class, 'delete'])->name('delete');
    });


});

