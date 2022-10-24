<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

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

    public function store(){
        
    }



}
