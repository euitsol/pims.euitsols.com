<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Division;
use App\Models\District;
use DataTables;
use Illuminate\Support\Facades\Auth;

class DistrictController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $this->check_access('view district');
        if ($request->ajax()) {
            $districts = District::with(['created_user','division'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($districts)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('division', function ($data) {
                        return $data->division->name;
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit district') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("district.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete district') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("district.delete", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $districts = District::where('deleted_at', null)->orderBy('division_id')->latest()->get();
        return view('pages.setup.district.index', ['districts' => $districts ]);
    }

    public function add(){
        $this->check_access('add district');
        $divisions = Division::where('deleted_at', null)->latest()->get();
        return view('pages.setup.district.create', ['divisions' => $divisions ]);
    }

    public function store(Request $request){
        $this->check_access('add district');
        $this->validate($request, [
            'name' => 'required|unique:districts,name|string|max:255',
            'division_name' => 'required|exists:divisions,id',
        ]);

        $district = new District;
        $district->name = $request->name;
        $district->division_id = $request->division_name;
        $district->created_by = auth()->user()->id;
        $district->created_at = Carbon::now()->toDateTimeString();
        $district->save();

        $this->message('success', 'District Created Successfullly');
        return redirect()->route('district.index');
    }

    public function details($id=null){
        if($id!=null){
            $semester = District::with(['division', 'created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($semester, 200);
        }
    }

    public function edit($id=null){
        $this->check_access('edit district');
        if($id!=null){
            $divisions = Division::where('deleted_at', null)->latest()->get();
            $district = District::findOrFail($id);
            return view('pages.setup.district.edit',['district' => $district, 'divisions' => $divisions]);
        }
    }

    public function edit_store(Request $request){
        $this->check_access('edit district');
        $this->validate($request, [
            'id' => 'required|exists:districts,id',
            'division_name' => 'required||exists:divisions,id',
        ]);
        $district = District::findOrFail($request->id);
        if($district->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:districts,name|string|max:255']);
        }

        $district->name = $request->name;
        $district->division_id = $request->division_name;
        $district->updated_at = Carbon::now()->toDateTimeString();
        $district->updated_by = auth()->user()->id;
        $district->save();

        $this->message('success', 'District '.$district->name.' updated successfully');
        return redirect()->route('district.index');
    }

    public function delete($id=null){
        $this->check_access('delete district');
        if($id != null){
            $district = District::findOrFail($id);
            $district->deleted_at = Carbon::now()->toDateTimeString();
            $district->deleted_by = auth()->user()->id;
            $district->save();
            $this->message('success', 'District '.$district->name.' deleted successfully');
            return redirect()->route('district.index');
        }
    }

}
