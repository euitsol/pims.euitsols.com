<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\CustomRole;
use App\Models\CustomPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $this->check_access('user view');
        $users = User::where('deleted_at', null)->latest()->get();
        return view('users.index', [ 'users' => $users ]);
    }

    public function add(){
        $this->check_access('user add');
        $roles = Role::where('deleted_at', null)->latest()->get();
        return view('users.create', [ 'roles' => $roles ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:users,name|string|max:255',
            'email' => 'required|unique:users,email|email|max:255',
            'password' => 'required',
            'role' => 'required|exists:roles,id',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
            'role_id' => $request->role,
            'created_by' => auth()->user()->id,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);
        $user->assignRole($user->role->name);
        $this->message('success', 'User Created Successfullly');
        return redirect()->route('users.index');
    }

    public function role_index(){
        $this->check_access('role view');
        $roles = CustomRole::where('deleted_at', null)->latest()->get();
        return view('users.role.index', [ 'roles' => $roles ]);
    }

    public function role_add(){
        $this->check_access('role add');
        $permissions = Permission::where('deleted_at', null)->latest()->get()->groupBy('prefix');
        return view('users.role.create', [ 'permissions' => $permissions ]);
    }

    public function role_store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:roles,name|string|max:255',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->name, 'created_by' => auth()->user()->id, 'created_at' => Carbon::now()->toDateTimeString()]);
        foreach($request->permission as $pm){
            $check = Permission::findOrFail($pm);
            $role->givePermissionTo($check);
        }
        $this->message('success', 'Role and Permission Assigned Successfullly');
        return redirect()->route('users.role.index');
    }

    public function permission_view(){
        $this->check_access('permission view');
        $permissions = CustomPermission::where('deleted_at', null)->orderBy('prefix')->get();
        return view('users.permission.index', [ 'permissions' => $permissions ]);
    }

    public function permission_add(){
        $this->check_access('permission add');
        return view('users.permission.create');
    }

    public function permission_store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
            'prefix' => 'required|string|unique:permissions,prefix|max:255',
        ]);
        $permission = Permission::create(['name' => $request->name, 'prefix' => $request->prefix, 'created_by' => auth()->user()->id, 'created_at' => Carbon::now()->toDateTimeString()]);
        $this->message('success', 'Permission Created Successfullly');
        return redirect()->route('users.permission.view');
    }

}
