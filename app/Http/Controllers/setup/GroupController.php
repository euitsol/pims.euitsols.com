<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Group;
use DataTables;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->check_access('view group');
        if ($request->ajax()) {
            $groups = Group::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($groups)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit group') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("group.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete group') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("group.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Group::where('deleted_at', null)->latest()->get();
        return view('pages.setup.group.index',$n);
    }

    public function create()
    {
        $this->check_access('add group');
        return view('pages.setup.group.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add group');
        $this->validate($request, [
            'name' => 'required|unique:groups,name|string|max:255',
        ]);

        $insert = new Group;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Group Created Successfullly');
        return redirect()->route('group.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Group::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit group');
        $n['db_data'] = Group::findOrFail($id);
        return view('pages.setup.group.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit group');
        $this->validate($request, [
            'id' => 'required|exists:groups,id',
        ]);

        $update = Group::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:groups,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Group Updated Successfully');
        return redirect()->route('group.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete group');
        if($id != null){
            $group = Group::findOrFail($id);
            $group->deleted_at = Carbon::now()->toDateTimeString();
            $group->deleted_by = auth()->user()->id;
            $group->save();
            $this->message('success', 'Group '.$group->name.' deleted successfully');
            return redirect()->route('group.index');
        }

    }
}
