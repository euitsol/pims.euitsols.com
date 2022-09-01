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
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="nav-icon fas fa-minus"></i>
                <p>View Users</p>
            </a>
        </li>
        @can('role view')
        <li class="nav-item">
            <a href="{{ route('users.role.index') }}" class="nav-link">
                <i class="nav-icon fas fa-minus"></i>
                <p>Users Roles</p>
            </a>
        </li>
        @endcan
        <li class="nav-item">
            <a href="{{ route('users.permission.add') }}" class="nav-link">
                <i class="nav-icon fas fa-minus"></i>
                <p>Permission</p>
            </a>
        </li>
    </ul>
</li>
