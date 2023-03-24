<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
{{-- User Management --}}
@if (Auth::user()->hasAnyPermission(['view user', 'view role', 'view permission']) || Auth::user()->role->id == 1)
    <li class="nav-item {{ Request::is('users/*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
                User Management
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @if (Auth::user()->can('view user') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link {{ Request::is('users/user-management/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>View Users</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view role') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('users.role.index') }}"
                        class="nav-link {{ Request::is('users/roles/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Users Roles</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view permission') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('users.permission.index') }}"
                        class="nav-link {{ Request::is('users/permission/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Permission</p>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif


{{-- Student Mangement --}}
<li class="nav-item {{ Request::is('student/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Student
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{-- Admission  --}}
        @if (Auth::user()->can('view admission') || Auth::user()->role->id == 1)
            <li class="nav-item {{ Request::is('student/admission/*') ? 'menu-open' : '' }}">
                <a href="" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Admission
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('student.student-admit.create') }}"
                            class="nav-link {{ Request::is('student/admission/student-admit/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>Admit Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.student-admit.index') }}"
                            class="nav-link {{ Request::is('student/admission/student-admit') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>Pending Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.admitted.decline.list') }}"
                            class="nav-link {{ Request::is('student/admission/decline/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>Declined Student</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif


        {{-- Student info  --}}
        @if (Auth::user()->can('view std_info') || Auth::user()->role->id == 1)
            <li class="nav-item {{ Request::is('student/information/*') ? 'menu-open' : '' }}">
                <a href="" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Student Info
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @php
                        $semester = App\Models\Semester::where('deleted_at', null)->get();
                    @endphp
                    @foreach ($semester as $key => $value)
                        <li class="nav-item">
                            <a href="{{ route('student.index', $value->id) }}"
                                class="nav-link {{ Request::is('student/information/index/' . $value->id) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-minus"></i>
                                <p>{{ $value->name }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    </ul>
</li>

{{-- Employee Mangement --}}
<li class="nav-item 
{{ Request::is('employee/*') ? 'menu-open' : '' }}
">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Employee
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{-- Employee Add  --}}
        @if (Auth::user()->can('view employee_add') || Auth::user()->role->id == 1)
            <li class="nav-item {{ Request::is('employee/employee_add/*') ? 'menu-open' : '' }}">
                <a href="" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Add Employee
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('employee.new_employee.create') }}"
                            class="nav-link {{ Request::is('employee/employee_add/new_employee/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>New Employee</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employee.new_employee.index') }}"
                            class="nav-link {{ Request::is('employee/employee_add/new_employee') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>Pending Employee</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employee.admitted.decline.list') }}"
                            class="nav-link {{ Request::is('employee/employee_add/decline/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>Declined Employee</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('employee.admitted.accept.list') }}" class="nav-link {{ Request::is('employee/employee_add/accept/*') ? 'active' : '' }}">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Employee List
                    </p>
                </a>
            </li>
        @endif
    </ul>
</li>

@if (Auth::user()->hasAnyPermission([
        'view department',
        'view exam-name',
        'view board',
        'view semester',
        'view session',
        'view semester-duration',
        'view group',
        'view blood-group',
        'view designation',
        'view division',
        'view district',
        'view shift',
        'view letter-grade',
        'view credit',
        'view subject',
        'view grade-calculation',
        'view nationality',
        'view routine',
    ]) || Auth::user()->role->id == 1)
    <li class="nav-item {{ Request::is('setup/*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
                Setup
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @if (Auth::user()->can('view blood-group') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('bloodgroup.index') }}"
                        class="nav-link {{ Request::is('setup/bloodgroup/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Blood Group</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view board') || Auth::user()->role->id == 1)
                <li class="nav-item ">
                    <a href="{{ route('board.index') }}"
                        class="nav-link {{ Request::is('setup/board/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Board</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view exam-name') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('exam-name-admission.index') }}"
                        class="nav-link {{ Request::is('setup/exam-name-admission/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Board Exam Name</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view building') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('building.index') }}"
                        class="nav-link {{ Request::is('setup/building/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Buildings</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view credit') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('credit.index') }}"
                        class="nav-link {{ Request::is('setup/credit/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Credit</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view designation') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('designation.index') }}"
                        class="nav-link {{ Request::is('setup/designation/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Emp Designation</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view department') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('department.index') }}"
                        class="nav-link {{ Request::is('setup/department/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Department</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view division') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('division.index') }}"
                        class="nav-link {{ Request::is('setup/division/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Division</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view district') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('district.index') }}"
                        class="nav-link {{ Request::is('setup/district/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>District</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view exam-name') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('exam-name-admission.index') }}"
                        class="nav-link {{ Request::is('setup/exam-name-admission/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Exam Name</p>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('examshifts.index') }}"
                    class="nav-link {{ Request::is('setup/exam-shift/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Exam Shift</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('examtypes.index') }}"
                    class="nav-link {{ Request::is('setup/exam-type/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Exam Type</p>
                </a>
            </li>

            @if (Auth::user()->can('view group') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('group.index') }}"
                        class="nav-link {{ Request::is('setup/group/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Group</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view grade-calculation') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('grade.index') }}"
                        class="nav-link {{ Request::is('setup/grade/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Grading Calculation</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view letter-grade') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('lettergrade.index') }}"
                        class="nav-link {{ Request::is('setup/lettergrade/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Letter Grade</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view nationality') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('nationality.index') }}"
                        class="nav-link {{ Request::is('setup/nationality/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Nationality</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view routine') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('routine.index') }}"
                        class="nav-link {{ Request::is('setup/routine/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Routine</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view semester') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('semester.index') }}"
                        class="nav-link {{ Request::is('setup/semester/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Semester</p>
                    </a>
                </li>
            @endif

            @if (Auth::user()->can('view session') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('session.index') }}"
                        class="nav-link {{ Request::is('setup/session/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Session</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view semester-duration') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('semesterDuration.index') }}"
                        class="nav-link {{ Request::is('setup/semester-duration/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Semester Duration</p>
                    </a>
                </li>
            @endif

            @if (Auth::user()->can('view shift') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('shift.index') }}"
                        class="nav-link {{ Request::is('setup/shift/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Shift</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view subject') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('subject.index') }}"
                        class="nav-link {{ Request::is('setup/subject/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Subject</p>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('subject-assign.index') }}"
                    class="nav-link {{ Request::is('setup/subject-assign/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Subject Assign</p>
                </a>
            </li>
            {{-- Teacher Assign --}}
            <li class="nav-item">
                <a href="{{ route('teacher-assign.index') }}"
                    class="nav-link {{ Request::is('setup/teacher-assign/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Teacher Assign</p>
                </a>
            </li>
        </ul>
    </li>
@endif


{{-- Teacher Mangement --}}
@if (Auth::user()->hasAnyPermission(['view teacher']) || Auth::user()->role->id == 1)
    <li class="nav-item {{ Request::is('teacher/*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>
                Teacher
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @if (Auth::user()->can('view teacher') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('teacher.index') }}"
                        class="nav-link {{ Request::is('teacher/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>View Teacher</p>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif

{{-- Attendance Managment --}}
@if (Auth::user()->hasAnyPermission(['view attendance']) || Auth::user()->role->id == 1)
    <li class="nav-item ">
        <a href="{{ route('attendance.filter') }}"
            class="nav-link {{ Request::is('attendance/*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Attendance </p>
        </a>
    </li>
@endif

<style>
    .nav .nav-item a .second-nav-text {
        margin-left: 15px;

    }

    .nav .nav-item a .third-nav-text {
        margin-left: 30px;

    }
</style>
{{-- LIbrary Mangement --}}
@if (Auth::user()->hasAnyPermission(['view library']) || Auth::user()->role->id == 1)
    <li class="nav-item {{ Request::is('library/*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-book"></i>
            <p>
                Library
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @if (Auth::user()->can('view library-setup') || Auth::user()->role->id == 1)
                <li class="nav-item {{ Request::is('library/setup/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle second-nav-text"></i>
                        <p>Setup <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->can('view category') || Auth::user()->role->id == 1)
                            <li class="nav-item">
                                <a href="{{ route('library.setup.category.index') }}"
                                    class="nav-link {{ Request::is('library/setup/category/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"></i>
                                    <p>Category</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->can('view bookshelf') || Auth::user()->role->id == 1)
                            <li class="nav-item">
                                <a href="{{ route('library.setup.bookshelf.index') }}"
                                    class="nav-link {{ Request::is('library/setup/bookshelf/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"></i>
                                    <p>Bookshelf</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->can('view add-book') || Auth::user()->role->id == 1)
                            <li class="nav-item">
                                <a href="{{ route('library.setup.book.index') }}"
                                    class="nav-link {{ Request::is('library/setup/books/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"></i>
                                    <p>Books</p>
                                </a>

                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (Auth::user()->can('view library-member') || Auth::user()->role->id == 1)
                <li class="nav-item ">
                    <a href="{{ route('library.member.index') }}"
                        class="nav-link {{ Request::is('library/member/*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle second-nav-text"></i>
                        <p>Register Member</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view assign-books') || Auth::user()->role->id == 1)
                <li class="nav-item ">
                    <a href="{{ route('library.book_assign.create') }}"
                        class="nav-link {{ Request::is('library/assign-books/*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle second-nav-text"></i>
                        <p>Assign Books</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view return-book') || Auth::user()->role->id == 1)
                <li class="nav-item ">
                    <a href="{{ route('library.return_book.create') }}"
                        class="nav-link {{ Request::is('library/return-books/*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle second-nav-text"></i>
                        <p>Return books</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view library-report') || Auth::user()->role->id == 1)
                <li class="nav-item {{ Request::is('library/report/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle second-nav-text"></i>
                        <p>Report <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->can('view daily') || Auth::user()->role->id == 1)
                            <li class="nav-item ">
                                <a href="{{ route('library.report.daily', [date('Y-m-d')]) }}"
                                    class="nav-link {{ Request::is('library/report/daily/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"></i>
                                    <p>Daily report</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->can('view all') || Auth::user()->role->id == 1)
                            <li class="nav-item ">
                                <a href="{{ route('library.report.all') }}"
                                    class="nav-link {{ Request::is('library/report/all') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"></i>
                                    <p>All report</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </li>
@endif

@if (Auth::user()->hasAnyPermission(['view asset']) || Auth::user()->role->id == 1)
    <li class="nav-item {{ Request::is('asset/*') ? 'menu-open' : '' }}">
        <a href="" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>Asset Managment<i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item {{ Request::is('asset/*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-circle second-nav-text"> </i>
                    <p>Setup <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('asset.setup.brand.index') }}"
                            class="nav-link {{ Request::is('asset/setup/brand/*') ? 'active' : '' }}">
                            <i class="fas fa-minus third-nav-text"></i>
                            <p>Brand</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('asset.setup.category.index') }}"
                            class="nav-link {{ Request::is('asset/setup/category/*') ? 'active' : '' }}">
                            <i class="fas fa-minus third-nav-text"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('asset.setup.section.index') }}"
                            class="nav-link {{ Request::is('asset/setup/section/*') ? 'active' : '' }}">
                            <i class="fas fa-minus third-nav-text"></i>
                            <p>Section</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('asset.setup.subcategory.index') }}"
                            class="nav-link {{ Request::is('asset/setup/subcategory/*') ? 'active' : '' }}">
                            <i class="fas fa-minus third-nav-text"></i>
                            <p>Subcategory</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('asset.setup.subsection.index') }}"
                            class="nav-link {{ Request::is('asset/setup/sub-section/*') ? 'active' : '' }}">
                            <i class="fas fa-minus third-nav-text"></i>
                            <p>Sub-section</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('asset.setup.supplier.index') }}"
                            class="nav-link {{ Request::is('asset/setup/supplier/*') ? 'active' : '' }}">
                            <i class="fas fa-minus third-nav-text"></i>
                            <p>Supplier</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('asset.setup.unit.index') }}"
                            class="nav-link {{ Request::is('asset/setup/unit/*') ? 'active' : '' }}">
                            <i class="fas fa-minus third-nav-text"></i>
                            <p>Unit</p>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('asset.product.index') }}"
                    class="nav-link {{ Request::is('asset/product/*') ? 'active' : '' }}">
                    <i class="nav-icon far fa-circle second-nav-text"> </i>
                    Add Product
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('asset.assign.product.index') }}"
                    class="nav-link {{ Request::is('asset/assign-product/*') ? 'active' : '' }}">
                    <i class="nav-icon far fa-circle second-nav-text"> </i>
                    Assign Product
                </a>
            </li>
            @if (Auth::user()->can('view asset-report') || Auth::user()->role->id == 1)
                <li class="nav-item {{ Request::is('asset/report/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle second-nav-text"> </i>
                        <p>Report <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->can('view report') || Auth::user()->role->id == 1)
                            <li class="nav-item ">
                                <a href="{{ route('asset.report.distribution.index') }}"
                                    class="nav-link {{ Request::is('asset/report/distribution/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"> </i>
                                    <p>Distribution Report </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->can('view report') || Auth::user()->role->id == 1)
                            <li class="nav-item ">
                                <a href="{{ route('asset.report.main_storage') }}"
                                    class="nav-link {{ Request::is('asset/report/main-storage/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"> </i>
                                    <p>Main Storage <span>Report</span> </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->can('view report') || Auth::user()->role->id == 1)
                            <li class="nav-item ">
                                <a href="{{ route('asset.report.product.index') }}"
                                    class="nav-link {{ Request::is('asset/report/product/*') || Request::is('asset/report/single-product/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"> </i>
                                    <p>Product Report</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->can('view report') || Auth::user()->role->id == 1)
                            <li class="nav-item ">
                                <a href="{{ route('asset.report.damage.search') }}"
                                    class="nav-link {{ Request::is('asset/report/damage/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus third-nav-text"> </i>
                                    <p>Damage Report</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </li>


@endif

<li class="nav-item {{ Request::is('exam-management/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Exam Management
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{ route('em.create.index') }}"
                class="nav-link {{ Request::is('exam-management/create-exam/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Create Exam</p>
            </a>
        </li>

    </ul>
</li>
