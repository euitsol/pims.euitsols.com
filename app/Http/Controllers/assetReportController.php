<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use App\Models\Department;
use App\Models\Product;
use App\Models\Section;
use App\Models\Subcategory;
use App\Models\Subsection;
use Illuminate\Http\Request;

class assetReportController extends Controller
{
    public function mainStorage(){

        $n['all_products'] = Product::where('deleted_by',null)->get()->groupBy('department_id');
        $n['departments'] = Department::where('deleted_by',null)->get();
        return view('pages.asset.report.main-storage',$n);
    }
    public function mainStorageFilter(Request $req){
        $n['str_date'] = $req->str_date;
        $n['end_date'] = $req->end_date;
        $n['department_id'] = $req->department_id;
        if($req->department_id){
            $n['department_wise'] = Product::where('deleted_by',null)
                                    ->where('department_id',$req->department_id == 'common_asset' ? null : $req->department_id)
                                    ->whereBetween('created_at',[$req->str_date,$req->end_date])
                                    ->get();
        }else{
            $n['all_products'] = Product::where('deleted_by',null)
                                ->whereBetween('created_at',[$req->str_date,$req->end_date])
                                ->get()->groupBy('department_id');
        }
        $n['departments'] = Department::where('deleted_by',null)->get();
        return view('pages.asset.report.main-storage',$n);
    }

    public function DepartmentWiseView($id){

        $department_id = $id == 'common_asset' ? null : $id;
        $n['department_products'] = Product::where('deleted_by',null)->where('department_id',$department_id)->get();
        return view('pages.asset.report.department-product-view',$n);
    }
    public function singleProductView($id){
        $n['single_product'] = Product::find($id);
        return view('pages.asset.report.single-product-view',$n);
    }
    public function distribution(){
        $n['departments'] = Department::where('deleted_at', null)->latest()->get();
        $n['sections'] = Section::where('deleted_at', null)->latest()->get();
        $n['subsections'] = Subsection::where('deleted_at', null)->latest()->get();
        // $n['categories'] = AssetCategory::where('deleted_at', null)->latest()->get();
        // $n['subcategories'] = Subcategory::where('deleted_at', null)->latest()->get();
        return view('pages.asset.report.distribution.index',$n);
    }
}
