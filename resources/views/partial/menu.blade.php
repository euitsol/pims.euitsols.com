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
                    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users/user-management/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>View Users</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view role') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('users.role.index') }}" class="nav-link {{ Request::is('users/roles/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Users Roles</p>
                    </a>
                </li>
            @endif
            @if (Auth::user()->can('view permission') || Auth::user()->role->id == 1)
                <li class="nav-item">
                    <a href="{{ route('users.permission.index') }}" class="nav-link {{ Request::is('users/permission/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Permission</p>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif


{{-- Student Mangement --}}
<li class="nav-item {{ Request::is('student/*') ? 'menu-open' : ''}}">
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
            <li class="nav-item {{Request::is('student/admission/*') ? 'menu-open': '' }}">
                <a href="" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Admission
                        <i class="fas fa-angle-left right"></i>
                    </p>

                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('student.student-admit.create') }}" class="nav-link {{Request::is('student/admission/student-admit/create') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>Admit Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.student-admit.index') }}" class="nav-link {{Request::is('student/admission/student-admit') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>Pending Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.admitted.decline.list') }}" class="nav-link {{Request::is('student/admission/decline/*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-minus"></i>
                            <p>Declined Student</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif


        {{-- Student info  --}}
        @if (Auth::user()->can('view std_info') || Auth::user()->role->id == 1)
            <li class="nav-item {{Request::is('student/information/*') ? 'menu-open' : ''}}">
                <a href="" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Student Info
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @php
                        $semester = App\Models\Semester::where('deleted_at',null)->get();
                    @endphp
                        @foreach ($semester as $key => $value)
                        <li class="nav-item">
                            <a href="{{ route('student.index',$value->id) }}" class="nav-link {{Request::is('student/information/index/'.$value->id) ? 'active' : ''}}">
                                <i class="nav-icon fas fa-minus"></i>
                                <p>{{$value->name}}</p>
                            </a>
                        </li>
                        @endforeach
                </ul>
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
                        <p>Lettter Grade</p>
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
        <a href="{{route('attendance.filter')}}" class="nav-link {{ Request::is('attendance/*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Attendance </p>
        </a>
    </li>
@endif

{{-- LIbrary Mangement --}}
@if (Auth::user()->hasAnyPermission(['view library']) || Auth::user()->role->id == 1)
    <li class="nav-item {{ Request::is('library/*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link ">
            <i class="fas fa-book"></i>
            <p>
                Libray
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @if (Auth::user()->can('view library-setup') || Auth::user()->role->id == 1)
                <li class="nav-item {{ Request::is('library/setup/*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>Setup <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->can('view library-setup-category') || Auth::user()->role->id == 1)
                            <li class="nav-item">
                                <a href="{{route('library.setup.category.index')}}"
                                    class="nav-link {{ Request::is('attendance/setup/category*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus"></i>
                                    <p>Category</p>
                                </a>

                            </li>
                        @endif
                        @if (Auth::user()->can('view add-book') || Auth::user()->role->id == 1)
                            <li class="nav-item">
                                <a href="{{route('library.setup.add_book.index')}}"
                                    class="nav-link {{ Request::is('library/setup/add_book/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-minus"></i>
                                    <p>Add Book</p>
                                </a>

                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </li>
@endif

