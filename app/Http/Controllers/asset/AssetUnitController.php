<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\AssetBaseUnit;
use App\Models\AssetUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetUnitController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['units'] = AssetUnit::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.unit.index',$n);
    }

    public function create(){
        $n['base_units'] = AssetBaseUnit::where('deleted_by',null)->orderBy('name')->get();
        return view('pages.asset.setup.unit.create',$n);
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:asset_units,name',
            'short_name' => 'required|string|unique:asset_units,short_name',
            'base_unit_id' => 'required|integer|exists:asset_base_units,id',
        ],[],[
                'name' => "Unit's name",
                'short_name' => "Unit's short name",
                'base_unit_id' => "Base unit",
            ]);
        $insert = new AssetUnit();
        $insert->name = $req->name;
        $insert->short_name = $req->short_name;
        $insert->base_unit_id = $req->base_unit_id;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Unit added successfully');
        return redirect()->route('asset.setup.unit.index');
    }

    public function edit($id){
        $n['base_units'] = AssetBaseUnit::where('deleted_by',null)->orderBy('name')->get();
        $n['unit'] = AssetUnit::with(['created_user','updated_user','deleted_user','baseUnit'])->findOrFail($id);
        return view('pages.asset.setup.unit.edit',$n);
    }

    public function update(Request $req){

        $this->validate($req,[
            'name' => "required|string|unique:asset_units,name,$req->id,id",
            'short_name' => "required|string|unique:asset_units,short_name,$req->id,id",
            'base_unit_id' => 'required|integer|exists:asset_base_units,id',
        ],[],[
            'name' => "Unit's name",
            'short_name' => "Unit's short name",
            'base_unit_id' => "Base unit",
        ]);

        $update = AssetUnit::findOrFail($req->id);
        $update->name = $req->name;
        $update->short_name =  $req->short_name;
        $update->base_unit_id =  $req->base_unit_id;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Unit updated successfully');
        return redirect()->route('asset.setup.unit.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = AssetUnit::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Unit deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $unit =AssetUnit::with(['created_user','updated_user','deleted_user','baseUnit'])->find($id);
            return response()->json($unit);
        }
    }
}
