<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Designation;
use DataTables;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $this->check_access('view designation');
        if ($request->ajax()) {
            $designations = Designation::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($designations)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can("edit designation") || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("designation.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can("delete designation") || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("designation.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Designation::where('deleted_at', null)->latest()->get();
        return view('pages.setup.designation.index',$n);
    }

    public function create()
    {
        $this->check_access('add designation');
        return view('pages.setup.designation.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add designation');
        $this->validate($request, [
            'name' => 'required|unique:designations,name|string|max:255',
        ]);

        $insert = new Designation;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Designation Created Successfullly');
        return redirect()->route('designation.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Designation::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit designation');
        $n['db_data'] = Designation::findOrFail($id);
        return view('pages.setup.designation.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit designation');
        $this->validate($request, [
            'id' => 'required|exists:designations,id',
        ]);

        $update = Designation::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:designations,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Designation Updated Successfully');
        return redirect()->route('designation.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete designation');
        if($id != null){
            $designation = Designation::findOrFail($id);
            $designation->deleted_at = Carbon::now()->toDateTimeString();
            $designation->deleted_by = auth()->user()->id;
            $designation->save();
            $this->message('success', 'Designation '.$designation->name.' deleted successfully');
            return redirect()->route('designation.index');
        }

    }
}
