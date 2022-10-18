<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Bloodgroup;
use DataTables;
use Illuminate\Support\Facades\Auth;

class BloodGroupController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->check_access('view blood-group');
        if ($request->ajax()) {
            $bloodgroups = Bloodgroup::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($bloodgroups)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can("edit blood-group") || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("bloodgroup.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can("delete blood-group") || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("bloodgroup.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Bloodgroup::where('deleted_at', null)->latest()->get();
        return view('pages.setup.bloodgroup.index',$n);
    }

    public function create()
    {
        $this->check_access('add blood-group');
        return view('pages.setup.bloodgroup.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add blood-group');
        $this->validate($request, [
            'name' => 'required|unique:bloodgroups,name|string|max:255',
        ]);

        $insert = new Bloodgroup;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Blood Group Created Successfullly');
        return redirect()->route('bloodgroup.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Bloodgroup::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit blood-group');
        $n['db_data'] = Bloodgroup::findOrFail($id);
        return view('pages.setup.bloodgroup.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit blood-group');
        $this->validate($request, [
            'id' => 'required|exists:bloodgroups,id',
        ]);

        $update = Bloodgroup::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:bloodgroups,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Blood Group Updated Successfully');
        return redirect()->route('bloodgroup.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete blood-group');
        if($id != null){
            $bloodgroup = Bloodgroup::findOrFail($id);
            $bloodgroup->deleted_at = Carbon::now()->toDateTimeString();
            $bloodgroup->deleted_by = auth()->user()->id;
            $bloodgroup->save();
            $this->message('success', 'Blood Group '.$bloodgroup->name.' deleted successfully');
            return redirect()->route('bloodgroup.index');
        }

    }
}

