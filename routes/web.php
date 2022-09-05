<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

    // Exam name for admission by sakib
    Route::resource('exam-name-admission', EAdmissionController::class);
    // Board by sakib
    Route::resource('board', BoardController::class);




});
