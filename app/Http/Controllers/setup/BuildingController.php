<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class BuildingController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $n['buildings'] = Building::where('deleted_at',null)->groupBy('name')->get();
        return view('pages.setup.building.index',$n);
    }

    public function create(){
        return view('pages.setup.building.create');
    }

    public function store(Request $req){
        $building_insert = new Building();
        $building_insert->name = $req->building_name;
        $building_insert->total_floor = $req->total_floor;
        $building_insert->location = '0';
        $building_insert->created_by = Auth::user()->id;
        $building_insert->save();
        foreach ($req->floor as $floor => $single_floor) {
            $floor_insert = new floor();
            $floor_insert->building_id = $building_insert->id;
            $floor_insert->floor = $floor;
            $floor_insert->created_by = Auth::user()->id;
            $floor_insert->save();
            if (isset($single_floor['room'])) {
                foreach ($single_floor['room'] as $key => $value) {
                    $room_insert = new Room();
                    $room_insert->floor_id = $floor_insert->id;
                    $room_insert->room = $value['room_no'];
                    $room_insert->total_seat = $value['total_seat'];
                    $room_insert->room_details = $value['room_details'];
                    $room_insert->created_by = Auth::user()->id;
                    $room_insert->save();
                }
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
