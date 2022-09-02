<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){

        $users = User::latest()->get();

        return view('users.index', [ 'users' => $users ]);
    }

    public function add(){

        $roles = Role::latest()->get();

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
        ]);


        $user->assignRole($user->role->name);

        $this->message('success', 'User Created Successfullly');
        return redirect()->route('users.index');
    }

    public function role_index(){

        $roles = Role::latest()->get();

        return view('users.role.index', [ 'roles' => $roles ]);
    }

    public function role_add(){

        $permissions = Permission::latest()->get()->groupBy('prefix');

        return view('users.role.create', [ 'permissions' => $permissions ]);
    }

    public function role_store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:roles,name|string|max:255',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->name]);

        foreach($request->permission as $pm){
            $check = Permission::findOrFail($pm);
            $role->givePermissionTo($check);
        }

        $this->message('success', 'Role and Permission Assigned Successfullly');
        return redirect()->route('users.role.index');

    }

    public function permission_add(){

        return view('users.permission.create');
    }

    public function permission_store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
            'prefix' => 'required|string|max:255',
        ]);

        $permission = Permission::create(['name' => $request->name, 'prefix' => $request->prefix, 'created_by' => auth()->user()->id]);

        $this->message('success', 'Permission Created Successfullly');
        return redirect()->route('users.permission.add');
    }

}
