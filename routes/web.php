<?php

use App\Http\Controllers\asset\AssetBrandController;
use App\Http\Controllers\asset\AssetCategoryController;
use App\Http\Controllers\asset\AssetDamageController;
use App\Http\Controllers\asset\AssetUnitController;
use App\Http\Controllers\asset\AssignProductController;
use App\Http\Controllers\asset\ProductController;
use App\Http\Controllers\asset\SectionController;
use App\Http\Controllers\asset\SubcategoryController;
use App\Http\Controllers\asset\SubsectionController;
use App\Http\Controllers\asset\SupplierController;
use App\Http\Controllers\assetReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\student\studentAdmitcontroller;
use App\Http\Controllers\employee\EmployeeAddController;
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
use App\Http\Controllers\setup\DesignationController;
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
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\setup\BuildingController;
use App\Http\Controllers\ClassContentController;
use App\Http\Controllers\library\AssignBookController;
use App\Http\Controllers\library\RerurnBookController;
use App\Http\Controllers\library\BookshelfController;
use App\Http\Controllers\library\BookController;
use App\Http\Controllers\library\CategoryController;
use App\Http\Controllers\library\LibraryReportController;
use App\Http\Controllers\library\LibraryMemberController;
use App\Http\Controllers\setup\RoutineController;
use App\Http\Controllers\setup\ExamTypeController;
use App\Http\Controllers\ExamManagementController;
use App\Http\Controllers\setup\ExamShiftController;

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

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});

Auth::routes();

//File pond file upload
Route::post('/file-upload/uploads', [FileUploadController::class, 'uploads'])->name('file.upload');

Route::group(['middleware' => ['auth', 'checkstatus']], function () {

    //Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //user role permission
    Route::group(['as' => 'users.', 'prefix' => 'users'], function () {

        // Users management
        Route::group(['prefix' => 'user-management'], function () {
            Route::get('/view', [UserController::class, 'index'])->name('index');
            Route::get('/add', [UserController::class, 'add'])->name('add');
            Route::post('/add-store', [UserController::class, 'store'])->name('store');
            Route::get('/details/{id}', [UserController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [UserController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
        });

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

    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile/edit', [UserController::class, 'profile_edit'])->name('profile.edit');
    });


    //All Common Ajax here
    //District fetch according to divission
    Route::get('district-fetch/{id}', [studentAdmitcontroller::class, 'ajax'])->name('district_fetch.ajax');

    //Subject Fetch accordingly Department
    Route::post('/subject-fetch', [SubjectAssignController::class, 'ajax'])->name('subject-fetch.ajax');

    //Subject Assign fetch means subject fetch accordingly session,department,semester from subject_assigns table
    Route::get('/subject-assign-fetch', [AttendanceController::class, 'subjectFetch'])->name('subject_fetch.ajax');

    //Teacher fetch accordingly subject
    Route::get('/teacher-fetch', [AttendanceController::class, 'teacherFetch'])->name('teacher_fetch.ajax');

    // Student fetch according to student id
    Route::get('/residential-student/fetch',[LibraryMemberController::class,'residentialStdFetch'])->name('residential.std.fetch');

    // Student fetch according to student id
    Route::get('/residential-teacher/fetch',[LibraryMemberController::class,'rdtTeacherFetch'])->name('residential.teacher.fetch');

    // Category fetch according to department in library
    Route::get('library/category-fetch/{id}',[AssignBookController::class,'categoryFetch'])->name('library.category_fetch');

    // Product fetch according to department in Assign Product
    Route::get('asset/product-fetch',[AssignProductController::class,'productFetch'])->name('asset.product_fetch.ajax');

    //End All Common Ajax here


    //Student
    Route::group(['as' => 'student.', 'prefix' => 'student'], function () {

        //Admission module
        Route::group(['prefix' => 'admission'], function () {
            //Admit student
            Route::resource('student-admit', studentAdmitcontroller::class);
            Route::get('/admitted/{id}', [studentAdmitcontroller::class, 'delete'])->name('admitted.destroy');

            // Student's Academic inf download
            Route::get('/registration-download/{id}', [studentAdmitcontroller::class, 'student_reg_download'])->name('reg.download');
            Route::get('/marksheet-download/{id}', [studentAdmitcontroller::class, 'student_marksheet_download'])->name('marksheet.download');

            // Decline students
            Route::group(['as' => 'admitted.decline.', 'prefix' => 'decline'], function () {
                Route::get('/std/{id}', [studentAdmitcontroller::class, 'decline_student'])->name('d');
                Route::get('/list', [studentAdmitcontroller::class, 'decline_list'])->name('list');
                Route::get('/show/{id}', [studentAdmitcontroller::class, 'decline_show'])->name('show');
                Route::get('/edit/{id}', [studentAdmitcontroller::class, 'decline_edit'])->name('edit');
                Route::post('/update}', [studentAdmitcontroller::class, 'decline_update'])->name('update');
            });

            //Accept student
            Route::group(['as' => 'admitted.accept.', 'prefix' => 'accept'], function () {
                Route::get('create/{id}', [SemesterAssignAdmitStd::class, 'create'])->name('create'); //route name = student.admitted.accept.create
                route::post('/store', [SemesterAssignAdmitStd::class, 'store'])->name('store'); //route name = student.admitted.accept.store
            });
        });

        // Student Information
        Route::get('/information/index/{id}', [StudentController::class, 'index'])->name('index'); //route name = student.index
        Route::get('/information/show/{id}', [StudentController::class, 'show'])->name('show'); //route name = student.show
        Route::get('/information/ajax', [StudentController::class, 'ajax'])->name('ajax'); //route name = student.ajax, url=>student/information/ajax
    });


    //Employee
    Route::group(['as' => 'employee.', 'prefix' => 'employee'], function () {

        //Employee module
        Route::group(['prefix' => 'employee_add'], function () {
            //Add Employee
            Route::resource('new_employee', EmployeeAddController::class);
            Route::get('/admitted/{id}', [EmployeeAddController::class, 'delete'])->name('admitted.destroy');

            // Employee Academic inf download
            Route::get('/registration-download/{id}', [EmployeeAddController::class, 'employee_reg_download'])->name('reg.download');
            Route::get('/marksheet-download/{id}', [EmployeeAddController::class, 'employee_marksheet_download'])->name('marksheet.download');
            Route::get('/certificate-download/{id}', [EmployeeAddController::class, 'employee_certificate_download'])->name('certificate.download');
            
            // Employee Experience Info Download
            Route::get('/ex_certificate-download/{id}', [EmployeeAddController::class, 'employee_ex_certificate_download'])->name('ex_certificate.download');

            // Employee Document download
            Route::get('/nid_or_dob-download/{id}', [EmployeeAddController::class, 'employee_nid_or_dob_download'])->name('nid_or_dob.download');
            Route::get('/cv-download/{id}', [EmployeeAddController::class, 'employee_cv_download'])->name('cv.download');
            Route::get('/cc-download/{id}', [EmployeeAddController::class, 'employee_cc_download'])->name('cc.download');

            // Decline Employee
            Route::group(['as' => 'admitted.decline.', 'prefix' => 'decline'], function () {
                Route::get('/emp/{id}', [EmployeeAddController::class, 'decline_employee'])->name('d');
                Route::get('/list', [EmployeeAddController::class, 'decline_list'])->name('list');
                Route::get('/show/{id}', [EmployeeAddController::class, 'decline_show'])->name('show');
                Route::get('/edit/{id}', [EmployeeAddController::class, 'decline_edit'])->name('edit');
                Route::post('/update}', [EmployeeAddController::class, 'decline_update'])->name('update');
            });

            // Accept Employee
            Route::group(['as' => 'admitted.accept.', 'prefix' => 'accept'], function () {
                Route::get('/emp/{id}', [EmployeeAddController::class, 'accept_employee'])->name('d');
                Route::get('/list', [EmployeeAddController::class, 'accept_list'])->name('list');
                Route::get('/show/{id}', [EmployeeAddController::class, 'accept_show'])->name('show');
                Route::get('/edit/{id}', [EmployeeAddController::class, 'accept_edit'])->name('edit');
                Route::post('/update}', [EmployeeAddController::class, 'accept_update'])->name('update');
            });


        });

    });

    Route::group(['prefix' => 'setup'], function () {
        //department Module
        Route::group(['prefix' => 'department'], function () {

            Route::resource('department', departmentController::class);
            Route::get('department/delete/{id}', [departmentController::class, 'delete'])->name('department.delete');
        });


        // Exam name for admission
        Route::group(['prefix' => 'exam-name-admission'], function () {
            Route::resource('exam-name-admission', EAdmissionController::class);
        });

        // Board
        Route::group(['as' => 'board.', 'prefix' => 'board'], function () {
            Route::get('/view', [BoardController::class, 'index'])->name('index');
            Route::get('/add', [BoardController::class, 'create'])->name('create');
            Route::post('/add-store', [BoardController::class, 'store'])->name('store');
            Route::get('/details/{id}', [BoardController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [BoardController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [BoardController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BoardController::class, 'destroy'])->name('destroy');
        });

        //Semester
        Route::group(['as' => 'semester.', 'prefix' => 'semester'], function () {
            Route::get('/view', [SemesterController::class, 'index'])->name('index');
            Route::get('/add', [SemesterController::class, 'add'])->name('add');
            Route::post('/add-store', [SemesterController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SemesterController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [SemesterController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SemesterController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [SemesterController::class, 'delete'])->name('delete');
        });
        //Session
        Route::group(['as' => 'session.', 'prefix' => 'session'], function () {
            Route::get('/view', [SessionController::class, 'index'])->name('index');
            Route::get('/add', [SessionController::class, 'add'])->name('add');
            Route::post('/add-store', [SessionController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SessionController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [SessionController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SessionController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [SessionController::class, 'delete'])->name('delete');
        });
        //Session
        Route::group(['as' => 'session.', 'prefix' => 'session'], function () {
            Route::get('/view', [SessionController::class, 'index'])->name('index');
            Route::get('/add', [SessionController::class, 'add'])->name('add');
            Route::post('/add-store', [SessionController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SessionController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [SessionController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SessionController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [SessionController::class, 'delete'])->name('delete');
        });
        //Semester Duration
        Route::group(['as' => 'semesterDuration.', 'prefix' => 'semester-duration'], function () {
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
        Route::group(['as' => 'group.', 'prefix' => 'group'], function () {
            Route::get('/view', [GroupController::class, 'index'])->name('index');
            Route::get('/add', [GroupController::class, 'create'])->name('create');
            Route::post('/add-store', [GroupController::class, 'store'])->name('store');
            Route::get('/details/{id}', [GroupController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [GroupController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [GroupController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [GroupController::class, 'destroy'])->name('destroy');
        });
        // Blood Group
        Route::group(['as' => 'bloodgroup.', 'prefix' => 'bloodgroup'], function () {
            Route::get('/view', [BloodGroupController::class, 'index'])->name('index');
            Route::get('/add', [BloodGroupController::class, 'create'])->name('create');
            Route::post('/add-store', [BloodGroupController::class, 'store'])->name('store');
            Route::get('/details/{id}', [BloodGroupController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [BloodGroupController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [BloodGroupController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BloodGroupController::class, 'destroy'])->name('destroy');
        });

        // Designation
        Route::group(['as' => 'designation.', 'prefix' => 'designation'], function () {
            Route::get('/view', [DesignationController::class, 'index'])->name('index');
            Route::get('/add', [DesignationController::class, 'create'])->name('create');
            Route::post('/add-store', [DesignationController::class, 'store'])->name('store');
            Route::get('/details/{id}', [DesignationController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [DesignationController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [DesignationController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [DesignationController::class, 'destroy'])->name('destroy');
        });

        // Division
        Route::group(['as' => 'division.', 'prefix' => 'division'], function () {
            Route::get('/view', [DivisionController::class, 'index'])->name('index');
            Route::get('/add', [DivisionController::class, 'create'])->name('create');
            Route::post('/add-store', [DivisionController::class, 'store'])->name('store');
            Route::get('/details/{id}', [DivisionController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [DivisionController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [DivisionController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [DivisionController::class, 'destroy'])->name('destroy');
        });

        // District
        Route::group(['as' => 'district.', 'prefix' => 'district'], function () {
            Route::get('/view', [DistrictController::class, 'index'])->name('index');
            Route::get('/add', [DistrictController::class, 'add'])->name('add');
            Route::post('/add-store', [DistrictController::class, 'store'])->name('store');
            Route::get('/details/{id}', [DistrictController::class, 'details'])->name('details');
            Route::get('/edit/{id}', [DistrictController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [DistrictController::class, 'edit_store'])->name('edit.store');
            Route::get('/delete/{id}', [DistrictController::class, 'delete'])->name('delete');
        });

        // Shift
        Route::group(['as' => 'shift.', 'prefix' => 'shift'], function () {
            Route::get('/view', [ShiftController::class, 'index'])->name('index');
            Route::get('/add', [ShiftController::class, 'create'])->name('create');
            Route::post('/add-store', [ShiftController::class, 'store'])->name('store');
            Route::get('/details/{id}', [ShiftController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [ShiftController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [ShiftController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [ShiftController::class, 'destroy'])->name('destroy');
        });

        // Letter Gradde
        Route::group(['as' => 'lettergrade.', 'prefix' => 'lettergrade'], function () {
            Route::get('/view', [LetterGradeController::class, 'index'])->name('index');
            Route::get('/add', [LetterGradeController::class, 'create'])->name('create');
            Route::post('/add-store', [LetterGradeController::class, 'store'])->name('store');
            Route::get('/details/{id}', [LetterGradeController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [LetterGradeController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [LetterGradeController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [LetterGradeController::class, 'destroy'])->name('destroy');
        });

        // Credit
        Route::group(['as' => 'credit.', 'prefix' => 'credit'], function () {
            Route::get('/view', [CreditController::class, 'index'])->name('index');
            Route::get('/add', [CreditController::class, 'create'])->name('create');
            Route::post('/add-store', [CreditController::class, 'store'])->name('store');
            Route::get('/details/{id}', [CreditController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [CreditController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [CreditController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CreditController::class, 'destroy'])->name('destroy');
        });

        // Subject
        Route::group(['as' => 'subject.', 'prefix' => 'subject'], function () {
            Route::get('/view', [SubjectController::class, 'index'])->name('index');
            Route::get('/add', [SubjectController::class, 'create'])->name('create');
            Route::post('/add-store', [SubjectController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SubjectController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [SubjectController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SubjectController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [SubjectController::class, 'destroy'])->name('destroy');
        });

        // Grade Calculation System
        Route::group(['as' => 'grade.', 'prefix' => 'grade'], function () {
            Route::get('/view', [GradeCalculationController::class, 'index'])->name('index');
            Route::get('/add', [GradeCalculationController::class, 'create'])->name('create');
            Route::post('/add-store', [GradeCalculationController::class, 'store'])->name('store');
            Route::get('/details/{id}', [GradeCalculationController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [GradeCalculationController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [GradeCalculationController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [GradeCalculationController::class, 'destroy'])->name('destroy');
        });

        // Nationality
        Route::group(['as' => 'nationality.', 'prefix' => 'nationality'], function () {
            Route::get('/view', [NationaltyController::class, 'index'])->name('index');
            Route::get('/add', [NationaltyController::class, 'create'])->name('create');
            Route::post('/add-store', [NationaltyController::class, 'store'])->name('store');
            Route::get('/details/{id}', [NationaltyController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [NationaltyController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [NationaltyController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [NationaltyController::class, 'destroy'])->name('destroy');
        });

        // Subject Assign
        Route::group(['as' => 'subject-assign.', 'prefix' => 'subject-assign'], function () {
            Route::get('/view', [SubjectAssignController::class, 'index'])->name('index');
            Route::get('/add-view', [SubjectAssignController::class, 'create'])->name('create');
            Route::post('/add-store', [SubjectAssignController::class, 'store'])->name('store');
            Route::get('/details/{id}', [SubjectAssignController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [SubjectAssignController::class, 'edit'])->name('edit');
            Route::post('/edit-store', [SubjectAssignController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [SubjectAssignController::class, 'destroy'])->name('destroy');
        });

        // Teacher Assign
        Route::group(['as' => 'teacher-assign.', 'prefix' => 'teacher-assign'], function () {
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

        // Routine
        Route::group(['as' => 'routine.', 'prefix' => 'routine'], function () {
            Route::get('/view', [RoutineController::class, 'index'])->name('index');
            Route::post('/search', [RoutineController::class, 'search'])->name('search');
            Route::post('/event-crud', [RoutineController::class, 'calendarEvents'])->name('event.crud');


            Route::get('/delete/{id}', [RoutineController::class, 'destroy'])->name('destroy');
        });

         // Building
         Route::controller(BuildingController::class)->prefix('building')->name('building.')->group( function () {
            Route::get('/view', 'index')->name('index');
            Route::get('/add', 'create')->name('create');
            Route::post('/add-store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/edit-store', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/name-check', 'nameCheck')->name('name_check');
        });

        //Exam Types
        Route::controller(ExamTypeController::class)->prefix('exam-type')->name('examtypes.')->group( function () {
            Route::get('/view', 'index')->name('index');
            Route::get('/add', 'create')->name('create');
            Route::post('/add-store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/edit-store', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/show/{id}', 'show')->name('show');
        });

        //Exam Shifts
        Route::controller(ExamShiftController::class)->prefix('exam-shift')->name('examshifts.')->group( function () {
            Route::get('/view', 'index')->name('index');
            Route::get('/add', 'create')->name('create');
            Route::post('/add-store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/edit-store', 'update')->name('update');
            Route::get('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/show/{id}', 'show')->name('show');
        });

    });

    // Teacher Module
    Route::group(['as' => 'teacher.', 'prefix' => 'teacher'], function () {
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

    // Attendance Magement
    Route::group(['as' => 'attendance.', 'prefix' => 'attendance'], function () {
        Route::get('/filter', [AttendanceController::class, 'filter'])->name('filter');
        Route::post('/filter/store', [AttendanceController::class, 'filterStore'])->name('filter.store');
        Route::get('/class/{n}', [AttendanceController::class, 'class'])->name('class');
        Route::get('/create/{id}/{class}', [AttendanceController::class, 'create'])->name('create');
        Route::post('/store', [AttendanceController::class, 'store'])->name('store');
    });

    // Class Content Magement
    Route::group(['as' => 'class_content.', 'prefix' => 'class-content'], function () {
        Route::get('/create/{attendace_id}/{class}', [ClassContentController::class, 'create'])->name('create'); //route = class_content.create
        Route::post('/store', [ClassContentController::class, 'store'])->name('store'); //route = class_content.store
        Route::get('/index/{id}/{class}', [ClassContentController::class, 'index'])->name('index'); //route = class_content.index
    });

    //Library Mangement
    Route::group(['as'=>'library.','prefix'=>'library'],function(){

        //Setup
        Route::group(['as'=>'setup.','prefix'=>'setup'],function(){

            //Category
            Route::controller(CategoryController::class)->prefix('category')->name('category.')->group(function(){
                Route::get('/index','index')->name('index'); //route = library.setup.category.index
                Route::get('/create','create')->name('create');//route = library.setup.category.create
                Route::post('/store','store')->name('store');//route = library.setup.category.store
                Route::get('/edit/{id}','edit')->name('edit');//route = library.setup.category.edit
                Route::post('/update','update')->name('update');//route = library.setup.category.update
                Route::get('/destroy/{id}','destroy')->name('destroy');//route = library.setup.category.destroy
                Route::get('/show/{id}','show')->name('show');//route = library.setup.category.show
            });

            //bookshelf
            Route::controller(BookshelfController::class)->prefix('bookshelf')->name('bookshelf.')->group(function(){
                Route::get('/index','index')->name('index'); //route = library.setup.bookshelf.index
                Route::get('/create','create')->name('create');//route = library.setup.bookshelf.create
                Route::post('/store','store')->name('store');//route = library.setup.bookshelf.store
                Route::get('/edit/{id}','edit')->name('edit');//route = library.setup.bookshelf.edit
                Route::post('/update','update')->name('update');//route = library.setup.bookshelf.update
                Route::get('/destroy/{id}','destroy')->name('destroy');//route = library.setup.bookshelf.destroy
                Route::get('/show/{id}','show')->name('show');//route = library.setup.bookshelf.show
            });

            //book
            Route::controller(BookController::class)->prefix('books')->name('book.')->group(function(){
                Route::get('/index','index')->name('index'); //route = library.setup.book.index
                Route::get('/create','create')->name('create');//route = library.setup.book.create
                Route::post('/store','store')->name('store');//route = library.setup.book.store
                Route::get('/edit/{id}','edit')->name('edit');//route = library.setup.book.edit
                Route::post('/update','update')->name('update');//route = library.setup.book.update
                Route::get('/destroy/{id}','destroy')->name('destroy');//route = library.setup.book.destroy
                Route::get('/show/{id}','show')->name('show');//route = library.setup.book.show
                Route::get('/qty_check','qtyCheck')->name('qty_check');//route = library.setup.book.qty_check

            });
        });
        //End setup

        //Members managment for library
        Route::controller(LibraryMemberController::class)->prefix('member')->name('member.')->group(function(){
            Route::get('/index','index')->name('index');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::post('/update','update')->name('update');
            Route::get('/show/{id}','show')->name('show');
            Route::get('/destroy/{id}','destroy')->name('destroy');
            Route::get('/id-check','idCheck')->name('id_check');
        });

        //Book assign management
        Route::controller(AssignBookController::class)->prefix('assign-books')->name('book_assign.')->group(function(){
            Route::get('/index','index')->name('index');
            Route::get('/create','create')->name('create');
            Route::get('/info','info')->name('info'); //studnet fetch according to student id
            Route::get('/book-info','book_info')->name('book_info'); //Books fetch according to category
            Route::get('/book-fetch','single_book_fetch')->name('single_book_fetch'); //Books fetch according to category
            Route::post('/store','store')->name('store');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::post('/update','update')->name('update');
            Route::get('/show/{id}','show')->name('show');
            Route::get('/destroy/{id}','destroy')->name('destroy');
            Route::get('/transection','transection')->name('transection');

        });
        //Book return management
        Route::controller(RerurnBookController::class)->prefix('return-books')->name('return_book.')->group(function(){
            Route::get('/create','create')->name('create');
            Route::get('/info','info')->name('info');
            Route::get('/show/{id}','show')->name('show');
            Route::get('/update/{id}','update')->name('update');
            Route::get('/payment','payment')->name('payment');
        });

        //Library report management

            //daily report
            Route::controller(LibraryReportController::class)->prefix('report')->name('report.')->group(function(){
                Route::get('/daily/{date}','dailyReport')->name('daily');
                Route::get('/all','allReport')->name('all');
                Route::post('/all','allReport')->name('all');
            });
    });

    //Asset Management
    Route::prefix('asset')->name('asset.')->group(function(){

        //setup
        Route::prefix('setup')->name('setup.')->group(function(){

            //Category
            Route::controller(AssetCategoryController::class)->prefix('category')->name('category.')->group(function(){
                Route::get('/index','index')->name('index'); //asset.setup.category.index
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });
            //Subcategory
            Route::controller(SubcategoryController::class)->prefix('subcategory')->name('subcategory.')->group(function(){
                Route::get('/index','index')->name('index'); //asset.setup.subcategory.index
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });
            //Section
            Route::controller(SectionController::class)->prefix('section')->name('section.')->group(function(){
                Route::get('/index','index')->name('index'); //asset.setup.section.index
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });
            //Sub-section
            Route::controller(SubsectionController::class)->prefix('sub-section')->name('subsection.')->group(function(){
                Route::get('/index','index')->name('index'); //asset.setup.subsection.index
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });

            //Supplier
            Route::controller(SupplierController::class)->prefix('supplier')->name('supplier.')->group(function(){
                Route::get('/index','index')->name('index'); //asset.setup.supplier.index
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });

            //Brand
            Route::controller(AssetBrandController::class)->prefix('brand')->name('brand.')->group(function(){
                Route::get('/index','index')->name('index'); //asset.setup.brand.index
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });

            //Unit
            Route::controller(AssetUnitController::class)->prefix('unit')->name('unit.')->group(function(){
                Route::get('/index','index')->name('index'); //asset.setup.unit.index
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });

        });

        //Product
        Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function(){
            Route::get('/index','index')->name('index'); //asset.product.index
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::post('/update','update')->name('update');
            Route::get('/show/{id}','show')->name('show');
            Route::get('/destroy/{id}','destroy')->name('destroy');
            Route::get('/subcategory/fetch','subcatFetch')->name('subcat.fetch');
            Route::get('/add/more/{id}','moreProduct')->name('add.more');
            Route::post('/add/more-store','moreProductStore')->name('add.more.store');
        });

        //Assign Product
        Route::controller(AssignProductController::class)->prefix('assign-product')->name('assign.product.')->group(function(){
            Route::get('/index','index')->name('index'); //asset.assign.product.index
            // Route::post('/create','create')->name('create');
            Route::get('/store','store')->name('store');
            Route::post('/main/store','mainStore')->name('main_assign');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::post('/update','update')->name('update');
            Route::get('/destroy/{id}','destroy')->name('destroy');
        });

         //Damage Product
         Route::controller(AssetDamageController::class)->prefix('damage')->name('damage.')->group(function(){
            Route::post('/store','store')->name('store');//asset.damage.store
        });

         //Report
         Route::controller(assetReportController::class)->prefix('report')->name('report.')->group(function(){
            Route::get('/main-storage/index','mainStorage')->name('main_storage');
            Route::post('/main-storage/filter','mainStorageFilter')->name('main_storage.filter');
            Route::get('/department-wise-product/view/{department}','DepartmentWiseView')->name('department_product.view');
            Route::get('/single-product/view/{id}','singleProductView')->name('single_product.view');

            //Distribution report
            Route::controller(AssetReportController::class)->prefix('distribution')->name('distribution.')->group(function(){
                Route::get('/index','distribution')->name('index');
                Route::post('/fetch','fetch')->name('fetch');
            });
            //Product report
            Route::controller(AssetReportController::class)->prefix('product')->name('product.')->group(function(){
                Route::get('/index','product')->name('index');
                Route::post('/productFetch','productFetch')->name('fetch');
            });

            //Damage report
            Route::controller(AssetReportController::class)->prefix('damage')->name('damage.')->group(function(){
                Route::get('/search','damagesearch')->name('search');
                Route::get('/fetch','damageFetch')->name('fetch');
            });
        });
    });


    //Exam Management
    Route::prefix('exam-management')->name('em.')->group(function(){

        //Create Exam
        Route::controller(ExamManagementController::class)->prefix('create-exam')->name('create.')->group(function(){
            Route::get('/index','index')->name('index');
            Route::post('/search','search')->name('search');
            Route::get('/show/{id}','show')->name('show');
            Route::get('/add/{id}','add')->name('add');
            Route::get('/update/{id}','update')->name('update');
            Route::post('/update-store','update_store')->name('update.store');
            Route::post('/store','store')->name('store');
            Route::get('/view/{id}','view')->name('view');
            Route::post('/get-routine','get_routine')->name('get_routine');
            Route::get('/delete/{id}','delete')->name('delete');
        });

    });

});
