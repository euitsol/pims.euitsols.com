<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\departmentController;
use App\Http\Controllers\student\studentAdmitcontroller;
use Illuminate\Support\Facades\Auth;
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
    Route::get('/permission/view', [UserController::class, 'permission_view'])->name('users.permission.view');
    Route::get('/permission/add', [UserController::class, 'permission_add'])->name('users.permission.add');
    Route::post('/permission/store', [UserController::class, 'permission_store'])->name('users.permission.store');


    //department Model

    // Route::resource('classRoom', 'ClassRoomController');
    Route::resource('department', departmentController::class);
    Route::resource('student-admit', studentAdmitcontroller::class);


});
