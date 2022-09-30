<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    //
    public function index(){
        return view('pages.setup.routine.index');
    }
}
