<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class assetReportController extends Controller
{
    public function mainStorage(){
        $n['all_products'] = Product::where('deleted_by',null)->get();
        $n['departments'] = Department::where('deleted_by',null)->get();
        return view('pages.asset.report.main-storage',$n);
    }
    public function mainStorageFilter(Request $req){
        $n['str_date'] = $req->str_date;
        $n['end_date'] = $req->end_date;
        $n['department_id'] = $req->department_id;

        $n['all_products'] = Product::where('deleted_by',null)
                                    ->where('department_id',$req->department_id)
                                    ->where('department_id',$req->department_id)
                                    ->whereBetween('created_at',[$req->str_date,$req->end_date])
                                    ->get();
        $n['departments'] = Department::where('deleted_by',null)->get();

        return view('pages.asset.report.main-storage',$n);
    }
}
