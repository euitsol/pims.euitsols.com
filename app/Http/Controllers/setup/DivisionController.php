<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Division;
use DataTables;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->check_access('view division');
        if ($request->ajax()) {
            $divisions = Division::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($divisions)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit division') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("division.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete division') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("division.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Division::where('deleted_at', null)->latest()->get();
        return view('pages.setup.division.index',$n);
    }

    public function create()
    {
        $this->check_access('add division');
        return view('pages.setup.division.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add division');
        $this->validate($request, [
            'name' => 'required|unique:divisions,name|string|max:255',
        ]);

        $insert = new Division;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Division Created Successfullly');
        return redirect()->route('division.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $division = Division::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($division, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit division');
        $n['db_data'] = Division::findOrFail($id);
        return view('pages.setup.division.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit division');
        $this->validate($request, [
            'id' => 'required|exists:divisions,id',
        ]);

        $update = Division::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:divisions,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Division Updated Successfully');
        return redirect()->route('division.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete division');
        if($id != null){
            $division = Division::findOrFail($id);
            $division->deleted_at = Carbon::now()->toDateTimeString();
            $division->deleted_by = auth()->user()->id;
            $division->save();
            $this->message('success', 'Division '.$division->name.' deleted successfully');
            return redirect()->route('division.index');
        }

    }
}
