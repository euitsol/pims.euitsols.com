<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Lettergrade;
use DataTables;
use Illuminate\Support\Facades\Auth;

class LetterGradeController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->check_access('view letter-grade');
        if ($request->ajax()) {
            $lettergrades = Lettergrade::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($lettergrades)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit letter-grade') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("lettergrade.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete letter-grade') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("lettergrade.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Lettergrade::where('deleted_at', null)->latest()->get();
        return view('pages.setup.lettergrade.index',$n);
    }

    public function create()
    {
        $this->check_access('add letter-grade');
        return view('pages.setup.lettergrade.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add letter-grade');
        $this->validate($request, [
            'name' => 'required|unique:lettergrades,name|string|max:255',
        ]);

        $insert = new Lettergrade;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Letter Grade Created Successfullly');
        return redirect()->route('lettergrade.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Lettergrade::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit letter-grade');
        $n['db_data'] = Lettergrade::findOrFail($id);
        return view('pages.setup.lettergrade.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit letter-grade');
        $this->validate($request, [
            'id' => 'required|exists:lettergrades,id',
        ]);

        $update = Lettergrade::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:lettergrades,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Letter Grade Updated Successfully');
        return redirect()->route('lettergrade.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete letter-grade');
        if($id != null){
            $lettergrade = Lettergrade::findOrFail($id);
            $lettergrade->deleted_at = Carbon::now()->toDateTimeString();
            $lettergrade->deleted_by = auth()->user()->id;
            $lettergrade->save();
            $this->message('success', 'Letter Grade '.$lettergrade->name.' deleted successfully');
            return redirect()->route('lettergrade.index');
        }

    }
}
