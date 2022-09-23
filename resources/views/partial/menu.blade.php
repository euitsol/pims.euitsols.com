<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
<li class="nav-item">
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
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>View Users</p>
                </a>
            </li>
        @endif
        @if (Auth::user()->can('view role') || Auth::user()->role->id == 1)
            <li class="nav-item">
                <a href="{{ route('users.role.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Users Roles</p>
                </a>
            </li>
        @endif
        @if (Auth::user()->can('view permission') || Auth::user()->role->id == 1)
            <li class="nav-item">
                <a href="{{ route('users.permission.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Permission</p>
                </a>
            </li>
        @endif
    </ul>
</li>


{{-- Student Mangement --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Student
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (Auth::user()->can('view admission') || Auth::user()->role->id == 1)
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Admission</p>
                </a>
                <ul class="nav nav-treeview">
                    @if (Auth::user()->can('view admit-student') || Auth::user()->role->id == 1)
                    <li class="nav-item">
                        <a href="{{ route('student-admit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-plus"></i>
                            <p>Admit Student</p>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->can('view show-admit-student') || Auth::user()->role->id == 1)
                    <li class="nav-item">
                        <a href="{{ route('student-admit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-plus"></i>
                            <p>Show Admission Student</p>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
</li>



{{-- @if (Auth::user()->can('view department', 'view exam-name', 'view board', 'view semester', 'view session', 'view semester-duration', 'view group', 'view blood-group', 'view division', 'view district', 'view shift', 'view letter-grade', 'view credit', 'view subject', 'view grade-calculation', 'view nationality') || Auth::user()->role->id == 1) --}}
<li class="nav-item {{Request::is('setup/*') ? 'menu-open' : ''}}">
    <a href="#" class="nav-link ">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Setup
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (Auth::user()->can('view department') || Auth::user()->role->id == 1)
        <li class="nav-item">
        <a href="{{ route('department.index') }}" class="nav-link {{ Request::is('setup/department/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Department</p>
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
        @if (Auth::user()->can('view board') || Auth::user()->role->id == 1)
            <li class="nav-item ">
                <a href="{{ route('board.index') }}" class="nav-link {{ Request::is('setup/board/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-minus"></i>
                    <p>Board</p>
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
        @if (Auth::user()->can('view group') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('group.index') }}" class="nav-link {{ Request::is('setup/group/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Group</p>
            </a>
        </li>
        @endif
        @if (Auth::user()->can('view blood-group') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('bloodgroup.index') }}"
                class="nav-link {{ Request::is('setup/bloodgroup/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Blood Group</p>
            </a>
        </li>
        @endif
        @if (Auth::user()->can('view division') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('division.index') }}" class="nav-link {{ Request::is('setup/division/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Division</p>
            </a>
        </li>
        @endif
        @if (Auth::user()->can('view district') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('district.index') }}" class="nav-link {{ Request::is('setup/district/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>District</p>
            </a>
        </li>
        @endif
        @if (Auth::user()->can('view shift') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('shift.index') }}" class="nav-link {{ Request::is('setup/shift/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Shift</p>
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
        @if (Auth::user()->can('view credit') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('credit.index') }}" class="nav-link {{ Request::is('setup/credit/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Credit</p>
            </a>
        </li>
        @endif
        @if (Auth::user()->can('view subject') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('subject.index') }}" class="nav-link {{ Request::is('setup/subject/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Subject</p>
            </a>
        </li>
        @endif
        @if (Auth::user()->can('view grade-calculation') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('grade.index') }}" class="nav-link {{ Request::is('setup/grade/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-minus"></i>
                <p>Grading Calculation</p>
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
        <li class="nav-item">
          <a href="{{ route('subject-assign.index') }}" class="nav-link {{ Request::is('setup/subject-assign/*') ? 'active' : '' }}">
          <i class="nav-icon fas fa-minus"></i>
          <p>Subject Assign</p>
          </a>
        </li>
    </ul>
</li>

