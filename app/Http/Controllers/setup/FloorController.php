<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class FloorController extends Controller
{
   public function create($id){
    $n['building'] = Building::findOrFail($id);
    return view('pages.setup.floor.create',$n);
   }
}
