<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Division;
use App\Models\District;

class DistrictController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $this->check_access('view district');
        $districts = District::where('deleted_at', null)->orderBy('division_id')->latest()->get();
        return view('pages.setup.district.index', ['districts' => $districts ]);
    }

    public function add(){
        $this->check_access('add district');
        $divisions = Division::where('deleted_at', null)->latest()->get();
        return view('pages.setup.district.create', ['divisions' => $divisions ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:districts,name|string|max:255',
            'division_name' => 'required||exists:divisions,id',
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
