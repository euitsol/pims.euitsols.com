<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function create($id)
    {

        $n['building'] = Building::findOrFail($id);
        return view('pages.setup.floor.test', $n);
    }

    public function store(Request $req)
    {
        foreach ($req->floor as $floor => $single_floor) {
            // dd($single_floor);
            if (isset($single_floor['room'])) {
                foreach ($single_floor['room'] as $key => $value) {
                    $insert = new Floor();
                    $insert->floor = $floor;
                    $insert->building_id = $req->building_id;
                    $insert->room_no = $value['room_no'];
                    $insert->total_seat = $value['total_seat'];
                    $insert->room_details = $value['room_details'];
                    $insert->save();
                }
            }
        }
    }

    public function assigned($id){
        $n['floor'] = Floor::with('created_user','updated_user','building')->where('deleted_at',null)->where('building_id',$id)->get()->groupBy('floor');
        return view('pages.setup.floor.assigned',$n);
    }
}
