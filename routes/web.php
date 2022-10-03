<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\student\studentAdmitcontroller;
use App\Http\Controllers\setup\departmentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\setup\EAdmissionController;
use App\Http\Controllers\setup\BoardController;
use App\Http\Controllers\setup\SemesterController;
use App\Http\Controllers\setup\SessionController;
use App\Http\Controllers\setup\SemesterDurationController;
use App\Http\Controllers\setup\GroupController;
use App\Http\Controllers\setup\BloodGroupController;
use App\Http\Controllers\setup\DivisionController;
use App\Http\Controllers\setup\DistrictController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\setup\ShiftController;
use App\Http\Controllers\setup\LetterGradeController;
use App\Http\Controllers\setup\CreditController;
use App\Http\Controllers\setup\SubjectController;
use App\Http\Controllers\setup\GradeCalculationController;
use App\Http\Controllers\setup\NationaltyController;
use App\Http\Controllers\setup\SubjectAssignController;
use App\Http\Controllers\setup\TeacherAssignController;
use App\Http\Controllers\teacher\TeacherController;
use App\Http\Controllers\student\SemesterAssignAdmitStd;
use App\Http\Controllers\student\StudentController;

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


Auth::routes();

//File pond file upload
Route::post('/file-upload/uploads', [FileUploadController::class, 'uploads'])->name('file.upload');

Route::group(['middleware' => ['auth', 'checkstatus']], function() {

    //Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //user roll permission
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

    //All Common Ajax here
        //District fetch according to divission
        Route::get('district-fetch/{id}', [studentAdmitcontroller::class, 'ajax'])->name('district_fetch.ajax');

        //Subject Fetch accordingly Department
        Route::post('/subject-fetch', [SubjectAssignController::class, 'ajax'])->name('subject-fetch.ajax');

    //Student
    Route::group(['as'=>'student.','prefix'=>'student'],function(){

        //Admission module
        Route::group(['prefix'=>'admission'],function(){
            //Admit student
            Route::resource('student-admit', studentAdmitcontroller::class);
            Route::get('/admitted/{id}', [studentAdmitcontroller::class,'delete'])->name('admitted.destroy');

            // Student's Academic inf download
            Route::get('/registration-download/{id}', [studentAdmitcontroller::class,'student_reg_download'])->name('reg.download');
            Route::get('/marksheet-download/{id}', [studentAdmitcontroller::class,'student_marksheet_download'])->name('marksheet.download');

            // Decline students
            Route::group(['as'=>'admitted.decline.','prefix'=>'decline'],function(){
                Route::get('/std/{id}', [studentAdmitcontroller::class,'decline_student'])->name('d');
                Route::get('/list', [studentAdmitcontroller::class, 'decline_list'])->name('list');
                Route::get('/show/{id}', [studentAdmitcontroller::class, 'decline_show'])->name('show');
                Route::get('/edit/{id}', [studentAdmitcontroller::class, 'decline_edit'])->name('edit');
                Route::post('/update}', [studentAdmitcontroller::class, 'decline_update'])->name('update');
            });

            //Accept student
            Route::group(['as'=>'admitted.accept.','prefix'=>'accept'],function(){
                Route::get('create/{id}', [SemesterAssignAdmitStd::class,'create'])->name('create');//route name = student.admitted.accept.create
                route::post('/store',[SemesterAssignAdmitStd::class,'store'])->name('store');//route name = student.admitted.accept.store
            });
        });

        // Student Information
        Route::get('/information/index/{id}', [StudentController::class, 'index'])->name('index');//route name = student.index
    });


    Route::group(['prefix'=> 'setup'],function(){
        //department Module
        Route::group(['prefix'=>'department'],function(){

            Route::resource('department', departmentController::class);
            Route::get('department/delete/{id}', [departmentController::class,'delete'])->name('department.delete');
        });


        // Exam name for admission
        Route::group(['prefix'=>'exam-name-admission'],function(){
            Route::resource('exam-name-admission', EAdmissionController::class);
        });

        // Board
        Route::group(['as' => 'board.', 'prefix' => 'board'], function() {
            Route::get('/view', [BoardController::class, 'index'])->name('index');
            Route::get('/add', [BoardController::class, 'create'])->name('create');
            Route::post('/add-store', [BoardController::class, 'store'])->name('store');
            Route::get('/details/{id}', [BoardController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [BoardController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [BoardController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BoardController::class, 'destroy'])->name('destroy');
        });

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
            //Session
        Route::group(['as' => 'session.', 'prefix' => 'session'], function() {
            Route::get('/view', [SessionController::class, 'index'])->name('index');
            Route::get('/add', [SessionController::class, 'add'])->name('add');
            Route::post('/add-store', [SessionController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SessionController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [SessionController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SessionController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [SessionController::class, 'delete'])->name('delete');
        });
            //Session
        Route::group(['as' => 'session.', 'prefix' => 'session'], function() {
            Route::get('/view', [SessionController::class, 'index'])->name('index');
            Route::get('/add', [SessionController::class, 'add'])->name('add');
            Route::post('/add-store', [SessionController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SessionController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [SessionController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SessionController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [SessionController::class, 'delete'])->name('delete');
        });
            //Semester Duration
        Route::group(['as' => 'semesterDuration.', 'prefix' => 'semester-duration'], function() {
            Route::get('/view', [SemesterDurationController::class, 'index'])->name('index');
            Route::get('/add', [SemesterDurationController::class, 'add'])->name('add');
            Route::post('/add-store', [SemesterDurationController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SemesterDurationController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [SemesterDurationController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SemesterDurationController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [SemesterDurationController::class, 'delete'])->name('delete');
            Route::get('/get-duration/{session_id}', [SemesterDurationController::class, 'get_duration'])->name('duration');
        });
            // Group
        Route::group(['as' => 'group.', 'prefix' => 'group'], function() {
            Route::get('/view', [GroupController::class, 'index'])->name('index');
            Route::get('/add', [GroupController::class, 'create'])->name('create');
            Route::post('/add-store', [GroupController::class, 'store'])->name('store');
            Route::get('/details/{id}', [GroupController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [GroupController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [GroupController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [GroupController::class, 'destroy'])->name('destroy');
        });
            // Blood Group
        Route::group(['as' => 'bloodgroup.', 'prefix' => 'bloodgroup'], function() {
            Route::get('/view', [BloodGroupController::class, 'index'])->name('index');
            Route::get('/add', [BloodGroupController::class, 'create'])->name('create');
            Route::post('/add-store', [BloodGroupController::class, 'store'])->name('store');
            Route::get('/details/{id}', [BloodGroupController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [BloodGroupController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [BloodGroupController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BloodGroupController::class, 'destroy'])->name('destroy');
        });

        // Division
        Route::group(['as' => 'division.', 'prefix' => 'division'], function() {
            Route::get('/view', [DivisionController::class, 'index'])->name('index');
            Route::get('/add', [DivisionController::class, 'create'])->name('create');
            Route::post('/add-store', [DivisionController::class, 'store'])->name('store');
            Route::get('/details/{id}', [DivisionController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [DivisionController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [DivisionController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [DivisionController::class, 'destroy'])->name('destroy');
        });

        // District
        Route::group(['as' => 'district.', 'prefix' => 'district'], function() {
            Route::get('/view', [DistrictController::class, 'index'])->name('index');
            Route::get('/add', [DistrictController::class, 'add'])->name('add');
            Route::post('/add-store', [DistrictController::class, 'store'])->name('store');
            Route::get('/details/{id}', [DistrictController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [DistrictController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [DistrictController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [DistrictController::class, 'delete'])->name('delete');
        });

        // Shift
        Route::group(['as' => 'shift.', 'prefix' => 'shift'], function() {
            Route::get('/view', [ShiftController::class, 'index'])->name('index');
            Route::get('/add', [ShiftController::class, 'create'])->name('create');
            Route::post('/add-store', [ShiftController::class, 'store'])->name('store');
            Route::get('/details/{id}', [ShiftController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [ShiftController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [ShiftController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [ShiftController::class, 'destroy'])->name('destroy');
        });

        // Letter Gradde
        Route::group(['as' => 'lettergrade.', 'prefix' => 'lettergrade'], function() {
            Route::get('/view', [LetterGradeController::class, 'index'])->name('index');
            Route::get('/add', [LetterGradeController::class, 'create'])->name('create');
            Route::post('/add-store', [LetterGradeController::class, 'store'])->name('store');
            Route::get('/details/{id}', [LetterGradeController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [LetterGradeController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [LetterGradeController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [LetterGradeController::class, 'destroy'])->name('destroy');
        });

        // Credit
        Route::group(['as' => 'credit.', 'prefix' => 'credit'], function() {
            Route::get('/view', [CreditController::class, 'index'])->name('index');
            Route::get('/add', [CreditController::class, 'create'])->name('create');
            Route::post('/add-store', [CreditController::class, 'store'])->name('store');
            Route::get('/details/{id}', [CreditController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [CreditController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [CreditController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CreditController::class, 'destroy'])->name('destroy');
        });

        // Subject
        Route::group(['as' => 'subject.', 'prefix' => 'subject'], function() {
            Route::get('/view', [SubjectController::class, 'index'])->name('index');
            Route::get('/add', [SubjectController::class, 'create'])->name('create');
            Route::post('/add-store', [SubjectController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SubjectController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [SubjectController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SubjectController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [SubjectController::class, 'destroy'])->name('destroy');
        });

        // Grade Calculation System
        Route::group(['as' => 'grade.', 'prefix' => 'grade'], function() {
            Route::get('/view', [GradeCalculationController::class, 'index'])->name('index');
            Route::get('/add', [GradeCalculationController::class, 'create'])->name('create');
            Route::post('/add-store', [GradeCalculationController::class, 'store'])->name('store');
            Route::get('/details/{id}', [GradeCalculationController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [GradeCalculationController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [GradeCalculationController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [GradeCalculationController::class, 'destroy'])->name('destroy');

        });

        // Nationality
        Route::group(['as' => 'nationality.', 'prefix' => 'nationality'], function() {
            Route::get('/view', [NationaltyController::class, 'index'])->name('index');
            Route::get('/add', [NationaltyController::class, 'create'])->name('create');
            Route::post('/add-store', [NationaltyController::class, 'store'])->name('store');
            Route::get('/details/{id}', [NationaltyController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [NationaltyController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [NationaltyController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [NationaltyController::class, 'destroy'])->name('destroy');
        });

         // Subject Assign
        Route::group(['as' => 'subject-assign.', 'prefix' => 'subject-assign'], function() {
            Route::get('/view', [SubjectAssignController::class, 'index'])->name('index');
            Route::get('/add-view', [SubjectAssignController::class, 'create'])->name('create');
            Route::post('/add-store', [SubjectAssignController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SubjectAssignController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [SubjectAssignController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SubjectAssignController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [SubjectAssignController::class, 'destroy'])->name('destroy');
        });

          // Teacher Assign
          Route::group(['as' => 'teacher-assign.', 'prefix' => 'teacher-assign'], function() {
            Route::get('/view', [TeacherAssignController::class, 'index'])->name('index');
            Route::get('/create/{id}', [TeacherAssignController::class, 'create'])->name('create');
            Route::post('/add-store', [TeacherAssignController::class, 'store'])->name('store');
            Route::get('/details/{id}', [TeacherAssignController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [TeacherAssignController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [TeacherAssignController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [TeacherAssignController::class, 'destroy'])->name('destroy');
            Route::get('/assign/{id}', [TeacherAssignController::class, 'assign'])->name('assign');
            Route::post('/assign/store', [TeacherAssignController::class, 'assignStore'])->name('assign-store');
        });

    });
});


// Teacher Module
Route::group(['as' => 'teacher.', 'prefix' => 'teacher'], function() {
    Route::get('/view', [TeacherController::class, 'index'])->name('index');
    Route::get('/add', [TeacherController::class, 'create'])->name('create');
    Route::post('/add-store', [TeacherController::class, 'store'])->name('store');
    Route::get('/details/{id}', [TeacherController::class, 'show'])->name('show');
    Route::get('/info/{id}', [TeacherController::class, 'info'])->name('info');
    Route::get('/edit/{id}', [TeacherController::class, 'edit'])->name('edit');
    Route::post('/edit-store', [TeacherController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [TeacherController::class, 'destroy'])->name('destroy');
    Route::get('division_ajax/{id}', [TeacherController::class, 'ajax'])->name('ajax');

});

