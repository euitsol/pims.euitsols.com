<?php

namespace App\Http\Controllers;

use App\Models\AssignProduct;
use App\Models\Department;
use App\Models\MainAssignProduct;
use App\Models\Product;
use App\Models\Section;
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
            $n['all_products'] = Product::where('deleted_by',null);

            if($req->str_date){
                $n['all_products'] =   $n['all_products']->where('created_at','>',$req->str_date);
            }
            if($req->end_date){
                $n['all_products'] =$n['all_products']->where('created_at','<',$req->str_date);
            }

            $n['all_products'] =$n['all_products']->get()->groupBy('department_id');
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
        $n['assigned_products'] = MainAssignProduct::where('deleted_by',null)->where('product_id',$id)->get();
        return view('pages.asset.report.single-product-view',$n);
    }

    public function distribution(){
        $n['departments'] = Department::where('deleted_at', null)->latest()->get();
        $n['sections'] = Section::where('deleted_at', null)->latest()->get();
        $n['subsections'] = Subsection::where('deleted_at', null)->latest()->get();
        return view('pages.asset.report.distribution.filter',$n);
    }

    public function fetch(Request $req){
        $assign_products = AssignProduct::with(['mainProduct', 'mainProduct.product','mainProduct.created_user','mainProduct.product.department', 'mainProduct.category',
                                                'mainProduct.subcategory', 'mainProduct.supplier', 'department'])->where('deleted_by',null);
       if($req->department_id != 'all'){
            $assign_products->where('department_id','=',$req->department_id);
            if(isset($req->section_id)){
                $assign_products->where('section_id','=',$req->section_id);
            }
            if(isset($req->subsection_id)){
                $assign_products->where('subsection_id','=',$req->subsection_id);
            }
       }

        if($req->str_date){
            $assign_products->where('created_at','>',$req->str_date);
        }
        if($req->end_date){
            $assign_products->where('created_at','<',$req->end_date);
        }
        $n['assign_products'] = $assign_products->get()->groupBy('department_id');

        return view('pages.asset.report.distribution.index',$n);
    }


    public function product(){
        $n['departments'] = Department::where('deleted_by',null)->get();
        return view('pages.asset.report.product',$n);
    }

    public function productFetch(Request $req){
        $this->validate($req,[
            'department_id' => 'nullable|exists:departments,id',
            'product_id' => 'required|exists:products,id',
        ],[],[
            'department_id' =>'Department Name',
            'product_id' =>'Product Name',
        ]);
        return redirect()->route('asset.report.single_product.view',[$req->product_id]);
    }
}
