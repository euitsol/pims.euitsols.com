<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Nationality;
use DataTables;
use Illuminate\Support\Facades\Auth;

class NationaltyController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->check_access('view nationality');
        if ($request->ajax()) {
            $nationalities = Nationality::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($nationalities)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit nationality') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("nationality.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete nationality') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("nationality.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Nationality::where('deleted_at', null)->latest()->get();
        return view('pages.setup.nationality.index',$n);
    }

    public function create()
    {
        $this->check_access('add nationality');
        return view('pages.setup.nationality.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add nationality');
        $this->validate($request, [
            'name' => 'required|unique:nationalities,name|string|max:255',
        ]);

        $insert = new Nationality;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Nationality Created Successfullly');
        return redirect()->route('nationality.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Nationality::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit nationality');
        $n['db_data'] = Nationality::findOrFail($id);
        return view('pages.setup.nationality.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit nationality');
        $this->validate($request, [
            'id' => 'required|exists:nationalities,id',
        ]);

        $update = Nationality::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:nationalities,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Nationality Updated Successfully');
        return redirect()->route('nationality.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete nationality');
        if($id != null){
            $nationality = Nationality::findOrFail($id);
            $nationality->deleted_at = Carbon::now()->toDateTimeString();
            $nationality->deleted_by = auth()->user()->id;
            $nationality->save();
            $this->message('success', 'Group '.$nationality->name.' deleted successfully');
            return redirect()->route('nationality.index');
        }

    }
}
