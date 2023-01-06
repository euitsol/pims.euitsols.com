<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\AssetDamage;
use Carbon\Carbon;
use Faker\Core\Number;
use Illuminate\Http\Request;

class AssetDamageController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function store(Request $req){
        $check = AssetDamage::where('product_id',$req->product_id)
                                ->where('main_assign_id',$req->main_assign_id)
                                ->first();
        if($check){
            $check->product_id = $req->product_id;
            $check->main_assign_id = $req->main_assign_id;
            $check->supplier_id = $req->supplier_id;
            $check->qty = $req->qty;
            $check->des = $req->des;
            $check->updated_at = Carbon::now()->toDateTimeString();
            $check->updated_by = auth()->user()->id;
            $check->save();
            return back()->with('success','Damage quantity saved');
        }else{
            $insert = new AssetDamage();
            $insert->product_id = $req->product_id;
            $insert->main_assign_id = $req->main_assign_id;
            $insert->supplier_id = $req->supplier_id;
            $insert->qty = $req->qty;
            $insert->des = $req->des;
            $insert->created_at = Carbon::now()->toDateTimeString();
            $insert->created_by = auth()->user()->id;
            $insert->save();
            return back()->with('success','Damage quantity saved');
        }

    }
}
