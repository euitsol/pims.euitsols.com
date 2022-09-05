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
            <a href="{{ route('users.permission.view') }}" class="nav-link">
                <i class="nav-icon fas fa-minus"></i>
                <p>Permission</p>
            </a>
        </li>
        @endif
    </ul>
</li>

{{-- //Department --}}
<li class="nav-item">
    <a href="{{ route('department.index') }}" class="nav-link {{ Request::is('departments') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Department</p>
    </a>
</li>

{{-- Student Managment  --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Students
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if(Auth::user()->can('user view') || Auth::user()->role->id == 1)
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="nav-icon fas fa-minus"></i>
                <p>Admission</p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('student-admit.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Admit Student</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Show Admited Student</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Declined Student Info</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-minus"></i>
                        <p>Aproved Student Info</p>
                    </a>
                </li> --}}
            </ul>
        </li>
        @endif
    </ul>
</li>
