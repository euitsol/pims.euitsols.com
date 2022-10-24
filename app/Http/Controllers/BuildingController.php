<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $n['buildings'] = Building::where('deleted_at',null)->get();
        return view('pages.setup.building.index',$n);
    }

    public function create(){

        return view('pages.setup.building.create');
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|unique:buildings,name',
            'floor' => 'required',
        ]);
        $insert = new Building();
        $insert->name = $req->name;
        $insert->floor = $req->floor;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        return redirect()->route('building.index')->with('success',"$req->name Successfully Added");
    }

    public function edit($id){
        $n['building'] = Building::findOrFail($id);
        return view('pages.setup.building.edit',$n);
    }

    public function update(Request $req){
        $this->validate($req,[
            'name' => "required",
            'floor' => 'required',
        ]);
        $update = Building::findOrFail($req->id);
        $update->name = $req->name;
        $update->floor = $req->floor;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = Auth::user()->id;
        $update->save();
        return redirect()->route('building.index')->with('success',"Building Successfully Updated");
    }

    public function destroy($id){
        $delete = Building::findOrFail($id);
        $delete->deleted_at = Carbon::now()->toDateTimeString();
        $delete->deleted_by = Auth::user()->id;
        $delete->save();
        return redirect()->back()->with('success',"Building Successfully Deleted");
    }



}
