<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\AssetDamage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssetDamageController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function store(Request $req){
        $insert = new AssetDamage();
        $insert->product_id = $req->product_id;
        $insert->main_assign_id = $req->main_assign_id;
        $insert->supplier_id = $req->supplier_id;
        $insert->qty = $req->qty;
        $insert->des = $req->des;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();
        return back()->with('success','Damage quantity saved successfully');
    }
}
