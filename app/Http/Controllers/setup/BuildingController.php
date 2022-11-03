<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Floor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Json;

class BuildingController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $n['buildings'] = Building::where('deleted_at',null)->groupBy('name')->get();
        // $n['buildings'] = Building::where('deleted_at',null)->groupBy('name')->get();
        // dd($n);
        // $n['floor'] = Floor::with('building')->where('deleted_at',null)->get();
        return view('pages.setup.building.index',$n);
    }

    public function create(){

        return view('pages.setup.building.create');
    }

    public function store(Request $req){
        // dd($req->all());
        // $this->validate($req, [
        //     'name' => 'required|string|unique:buildings,name',
        //     'floor' => 'required|integer',
        //     'location' => 'required',
        // ]);
        // $insert = new Building();
        // $insert->name = $req->name;
        // $insert->floor = $req->floor;
        // $insert->location = $req->location;
        // $insert->created_by = Auth::user()->id;
        // $insert->save();
        foreach ($req->floor as $floor => $single_floor) {
            // dd($single_floor['total_room']);
            $name = $req->building_name;
            $total_floor = $req->total_floor;
            if (isset($single_floor['room'])) {
                $total_room = $single_floor['total_room'];
                foreach ($single_floor['room'] as $key => $value) {
                    $insert = new Building();
                    $insert->name = $name;
                    $insert->total_floor = $total_floor;
                    $insert->floor = $floor;
                    $insert->location = '0';
                    $insert->total_room = $total_room;
                    $insert->room = $value['room_no'];
                    $insert->total_seat = $value['total_seat'];
                    $insert->room_details = $value['room_details'];
                    $insert->created_by = Auth::user()->id;
                    $insert->save();
                }
            }else{
                $insert = new Building();
                $insert->name = $name;
                $insert->total_floor = $total_floor;
                $insert->floor = $floor;
                $insert->location = 0;
                $insert->total_room = 0;
                $insert->total_seat = 0;
                $insert->created_by = Auth::user()->id;
                $insert->save();
            }
        }
        return redirect()->route('building.index')->with('success',"$req->name Successfully Added");
    }

    public function edit($id){
        $n['building'] = Building::findOrFail($id);
        return view('pages.setup.building.edit',$n);
    }

    public function update(Request $req){
        $this->validate($req,[
            'name' => "required|string",
            'floor' => 'required|integer',
            'location' => 'required',
        ]);
        $update = Building::findOrFail($req->id);
        $update->name = $req->name;
        $update->floor = $req->floor;
        $update->location = $req->location;
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

    public function show($id = null){
        if($id!=null){
            $building = Building::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return response()->json($building);
        }

    }
}
