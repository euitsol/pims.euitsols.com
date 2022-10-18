<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Shift;
use DataTables;
use Illuminate\Support\Facades\Auth;


class ShiftController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->check_access('view shift');
        if ($request->ajax()) {
            $shifts = Shift::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($shifts)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can("edit shift") || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("shift.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can("delete shift") || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("shift.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Shift::where('deleted_at', null)->latest()->get();
        return view('pages.setup.shift.index',$n);
    }

    public function create()
    {
        $this->check_access('add shift');
        return view('pages.setup.shift.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add shift');
        $this->validate($request, [
            'name' => 'required|unique:shifts,name|string|max:255',
        ]);

        $insert = new Shift;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Shift Created Successfullly');
        return redirect()->route('shift.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $shift = Shift::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($shift, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit shift');
        $n['db_data'] = Shift::findOrFail($id);
        return view('pages.setup.shift.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit shift');
        $this->validate($request, [
            'id' => 'required|exists:shifts,id',
        ]);

        $update = Shift::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:shifts,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Shift Updated Successfully');
        return redirect()->route('shift.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete shift');
        if($id != null){
            $shift = Shift::findOrFail($id);
            $shift->deleted_at = Carbon::now()->toDateTimeString();
            $shift->deleted_by = auth()->user()->id;
            $shift->save();
            $this->message('success', $shift->name.' deleted successfully');
            return redirect()->route('shift.index');
        }

    }
}
