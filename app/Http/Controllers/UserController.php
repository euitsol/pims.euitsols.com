<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\CustomRole;
use App\Models\CustomPermission;
use App\Models\RoleHasPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use DB;
use DataTables;

class UserController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $this->check_access('view user');
        if ($request->ajax()) {
            $users = User::with(['created_user','role'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($users)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('role', function ($data) {
                        return $data->role->name;
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit user') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("users.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete user') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("users.delete", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $users = User::where('deleted_at', null)->latest()->get();
        return view('users.index', [ 'users' => $users ]);
    }

    public function add(){
        $this->check_access('add user');
        $roles = Role::where('deleted_at', null)->latest()->get();
        return view('users.create', [ 'roles' => $roles ]);
    }

    public function store(Request $request){
        $this->check_access('add user');
        $this->validate($request, [
            'name' => 'required|unique:users,name,NULL,id,deleted_at,NULL|string|max:255',
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

    public function details($id=null){
        if($id!=null){
            $user = User::with(['created_user', 'updated_user', 'deleted_user', 'role'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($user, 200);
        }
    }

    public function edit($id=null){
        $this->check_access('edit user');
        if($id!=null){
            $roles = Role::where('deleted_at', null)->latest()->get();
            $user = User::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return view('users.edit',['user' => $user, 'roles' => $roles]);
        }
    }

    public function edit_store(Request $request){
        $this->check_access('edit user');
        $this->validate($request, [
            'id' => 'required|exists:users,id',
            'password' => 'nullable',
        ]);
        $user = User::findOrFail($request->id);
        if($user->email != $request->email){
            $this->validate($request, [ 'email' => 'required|unique:users,email|email|max:255']);
        }
        if($user->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:users,name|string|max:255']);
        }
        if($user->role_id != $request->role){
            $this->validate($request, ['role' => 'nullable|exists:roles,id']);
        }
        $user->email = $request->email;
        $user->name = $request->name;
        $user->role_id = $request->role;
        if(isset($request->password)) $user->password = Hash::make($request->password);
        $user->updated_at = Carbon::now()->toDateTimeString();
        $user->updated_by = auth()->user()->id;
        $user->save();
        $this->message('success', 'User '.$user->name.' updated successfully');
        return redirect()->route('users.index');
    }

    public function delete($id=null){
        $this->check_access('delete user');
        if($id != null){
            $user = User::findOrFail($id);
            $user->deleted_at = Carbon::now()->toDateTimeString();
            $user->deleted_by = auth()->user()->id;
            $user->save();
            $this->message('success', 'User '.$user->name.' deleted successfully');
            return redirect()->route('users.index');
        }
    }

    public function role_index(Request $request){
        $this->check_access('view role');
        if ($request->ajax()){
            $roles = CustomRole::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($roles)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit role') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("users.role.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete role') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("users.role.delete", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $roles = CustomRole::where('deleted_at', null)->latest()->get();
        return view('users.role.index', [ 'roles' => $roles ]);
    }

    public function role_add(){
        $this->check_access('add role');
        $permissions = Permission::where('deleted_at', null)->latest()->get()->groupBy('prefix');
        return view('users.role.create', [ 'permissions' => $permissions ]);
    }

    public function role_store(Request $request){
        $this->check_access('add role');
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

    public function role_details($id=null){
        if($id!=null){
            $role = CustomRole::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($role, 200);
        }
    }

    public function role_edit($id=null){
        $this->check_access('edit role');
        if($id!=null){
            $role = Role::findOrFail($id);
            $permissions = Permission::where('deleted_at', null)->latest()->get()->groupBy('prefix');
            return view('users.role.edit', ['role' => $role, 'permissions' => $permissions]);
        }
    }

    public function role_edit_store(Request $request){
        $this->check_access('edit role');
        $this->validate($request, [
            'id' => 'required|exists:roles,id',
            'permission' => 'required',
        ]);
        $role = Role::findOrFail($request->id);
        if($role->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:roles,name|string|max:255']);
        }
        $role->name = $request->name;
        $role->updated_at = Carbon::now()->toDateTimeString();
        $role->updated_by = auth()->user()->id;
        $role->save();

        $role_has_permission = RoleHasPermission::where('role_id', $role->id)->delete();
        foreach($request->permission as $pm){
            $check = Permission::findOrFail($pm);
            $role->givePermissionTo($check);
        }
        $this->message('success', 'Role and Permission Updated Successfullly');
        return redirect()->route('users.role.index');
    }

    public function role_delete($id=null){
        $this->check_access('delete role');
        if($id!=null){
            $role = Role::findOrFail($id);
            $role->deleted_at = Carbon::now()->toDateTimeString();
            $role->deleted_by = auth()->user()->id;
            $role->save();
            $this->message('success', 'Role '.$role->name.' deleted successfully');
            return redirect()->route('users.role.index');
        }
    }

    public function permission_view(Request $request){
        $this->check_access('view permission');
        if ($request->ajax()){
            $permissions = CustomPermission::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($permissions)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit permission') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("users.permission.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete permission') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("users.permission.delete", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $permissions = CustomPermission::where('deleted_at', null)->orderBy('prefix')->get();
        return view('users.permission.index', [ 'permissions' => $permissions ]);
    }

    public function permission_add(){
        $this->check_access('add permission');
        return view('users.permission.create');
    }

    public function permission_store(Request $request){
        $this->check_access('add permission');
        $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
            'prefix' => 'required|string|max:255',
        ]);
        $permission = Permission::create(['name' => $request->name, 'prefix' => $request->prefix, 'created_by' => auth()->user()->id, 'created_at' => Carbon::now()->toDateTimeString()]);
        $this->message('success', 'Permission Created Successfullly');
        return redirect()->route('users.permission.index');
    }

    public function permission_details($id=null){
        if($id!=null){
            $permission = CustomPermission::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($permission, 200);
        }
    }

    public function permission_edit($id=null){
        $this->check_access('edit permission');
        if($id!=null){
            $permission = Permission::findOrFail($id);
            return view('users.permission.edit', ['permission' => $permission]);
        }
    }

    public function permission_edit_store(Request $request){
        $this->check_access('edit permission');
        $this->validate($request, [
            'id' => 'required|exists:permissions,id',
            'prefix' => 'required|string|max:255'
        ]);
        $permission = CustomPermission::findOrFail($request->id);
        if($permission->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:permissions,name|string|max:255']);
        }

        $permission->name = $request->name;
        $permission->prefix = $request->prefix;
        $permission->updated_at = Carbon::now()->toDateTimeString();
        $permission->updated_by = auth()->user()->id;
        $permission->save();

        $this->message('success', 'Permission Updated Successfullly');
        return redirect()->route('users.permission.index');
    }

    public function permission_delete($id=null){
        $this->check_access('delete permission');
        if($id!=null){
            $permission = CustomPermission::findOrFail($id);
            $permission->deleted_at = Carbon::now()->toDateTimeString();
            $permission->deleted_by = auth()->user()->id;
            $permission->save();
            $this->message('success', 'Permission '.$permission->name.' deleted successfully');
            return redirect()->route('users.permission.index');
        }
    }

    public function profile(){
        return view('users.profile.index', ['user' => Auth::user()]);
    }

    public function profile_edit(Request $request){
        $this->validate($request, [
            'password' => 'nullable',
        ]);
        $user = User::findOrFail(auth()->user()->id);
        if($user->email != $request->email){
            $this->validate($request, [ 'email' => 'required|unique:users,email|email|max:255']);
        }
        if($user->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:users,name|string|max:255']);
        }
        $user->email = $request->email;
        $user->name = $request->name;
        if(isset($request->password)) $user->password = Hash::make($request->password);
        $user->updated_at = Carbon::now()->toDateTimeString();
        $user->updated_by = auth()->user()->id;
        $user->save();
        $this->message('success', 'Profile updated successfully');
        return redirect()->route('home');
    }

}
