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
        @if(Auth::user()->can('user view') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="nav-icon fas fa-minus"></i>
                <p>View Users</p>
            </a>
        </li>
        @endif
        @if(Auth::user()->can('role view') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('users.role.index') }}" class="nav-link">
                <i class="nav-icon fas fa-minus"></i>
                <p>Users Roles</p>
            </a>
        </li>
        @endif
        @if(Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('users.permission.index') }}" class="nav-link">
                <i class="nav-icon fas fa-minus"></i>
                <p>Permission</p>
            </a>
        </li>
        @endif
    </ul>
</li>

{{-- //Department --}}
<li class="nav-item">
    <a href="{{ route('department.index') }}" class="nav-link {{ Request::is('department') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Department</p>
    </a>
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
        @if(Auth::user()->can('user view') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Admission</p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('student-admit.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Admit Student</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student-admit.show',1) }}" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Show Admission Student</p>
                    </a>
                </li>
            </ul>
        </li>
        @endif
    </ul>
</li>


<li class="nav-item">
    <a href="{{ route('exam-name-admission.index') }}" class="nav-link {{ Request::is('eadmission') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Exam Name</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('board.index') }}" class="nav-link {{ Request::is('board') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Board</p>
    </a>
</li>

@if(Auth::user()->can('semester view') || Auth::user()->role->id == 1)
<li class="nav-item">
    <a href="{{ route('semester.index') }}" class="nav-link {{ Request::is('semester') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book-open"></i>
        <p>Semester</p>
    </a>
</li>
@endif

@if(Auth::user()->can('session view') || Auth::user()->role->id == 1)
<li class="nav-item">
    <a href="{{ route('session.index') }}" class="nav-link {{ Request::is('session') ? 'active' : '' }}">
        <i class=" nav-icon fas fa-calendar-alt"></i>
        <p>Session</p>
    </a>
</li>
@endif
@if(Auth::user()->can('semester duration view') || Auth::user()->role->id == 1)
<li class="nav-item">
    <a href="{{ route('semesterDuration.index') }}" class="nav-link {{ Request::is('semester-dueation') ? 'active' : '' }}">
        <i class=" nav-icon fas fa-calendar-alt"></i>
        <p>Semester Duration</p>
    </a>
</li>
@endif
<li class="nav-item">
    <a href="{{ route('group.index') }}" class="nav-link {{ Request::is('group') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Group</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('bloodgroup.index') }}" class="nav-link {{ Request::is('bloodgroup') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Blood Group</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('division.index') }}" class="nav-link {{ Request::is('division') ? 'active' : '' }}">
        <i class="nav-icon fas fa-street-view"></i>
        <p>Division</p>
    </a>
</li>
