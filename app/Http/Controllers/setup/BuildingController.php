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
        $n['buildings'] = Building::with(['created_user', 'updated_user', 'deleted_user','floor'])->where('deleted_at',null)->get();
        return view('pages.setup.building.index',$n);
    }

    public function create(){
        return view('pages.setup.building.create');
    }

    public function store(Request $req){
        $building_insert = new Building();
        $building_insert->name = $req->building_name;
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
                    $room_insert->name = $value['room_name'];
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
    //    dd($req->all());
       $building_update = Building::findOrFail($req->id);
       $building_update->name = $req->building_name;
       $building_update->location = '0';
       $building_update->updated_by = Auth::user()->id;
       $building_update->save();

        //delete floor and room
        $exists_floors = Floor::where('building_id',$req->id)->get();
        foreach($exists_floors as $exist_floor){
         Room::where('floor_id',$exist_floor->id)->delete();
        }
        Floor::where('building_id',$req->id)->delete();

       foreach ($req->floor as $floor => $single_floor) {
           //save floor
           $floor_update = new Floor();
           $floor_update->building_id = $building_update->id;
           $floor_update->floor = $floor;
           $floor_update->updated_by = Auth::user()->id;
           $floor_update->save();
           if (isset($single_floor['room'])) {
               foreach ($single_floor['room'] as $key => $value) {
                    //save room
                   $room_update = new Room();
                   $room_update->floor_id = $floor_update->id;
                   $room_update->room = $value['room_no'];
                   $room_update->name = $value['room_name'];
                   $room_update->total_seat = $value['total_seat'];
                   $room_update->room_details = $value['room_details'];
                   $room_update->updated_by = Auth::user()->id;
                   $room_update->save();
               }
           }
       }
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
            $n['building'] = Building::with(['created_user', 'updated_user', 'deleted_user','floor'])->where('deleted_at', null)->where('id', $id)->first();
            return view("pages.setup.building.show",$n);
        }

    }

    public function nameCheck(Request $req){
        $check = Building::where('deleted_at',null)->where('name',$req->name)->first();
        if($check === null){
            return 1;
        }else{
            return 0;
        }
        // return response()->json($req->name);
    }
}
