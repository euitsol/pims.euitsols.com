<?php

namespace App\Http\Controllers;

use App\Models\AssetDamage;
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
            //department wise product show
            $n['department_wise'] = Product::where('deleted_by',null)
                                    ->where('department_id',$req->department_id == 'common_asset' ? null : $req->department_id);
                                    // ->whereBetween('created_at',[$req->str_date,$req->end_date])
                                    // ->get();
            if($req->str_date){
                $n['department_wise'] =   $n['department_wise']->where('created_at','>',$req->str_date);
            }
            if($req->end_date){
                $n['department_wise'] =$n['department_wise']->where('created_at','<',$req->end_date);
            }
            $n['department_wise'] =$n['department_wise']->get();
        }else{
            //all product show
            $n['all_products'] = Product::where('deleted_by',null);

            if($req->str_date){
                $n['all_products'] =   $n['all_products']->where('created_at','>',$req->str_date);
            }
            if($req->end_date){
                $n['all_products'] =$n['all_products']->where('created_at','<',$req->end_date);
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
            $n['department'] = Department::find($req->department_id)->department_name;
            if(isset($req->section_id)){
                $assign_products->where('section_id','=',$req->section_id);
                $n['section'] = Section::find($req->section_id)->name;
            }
            if(isset($req->subsection_id)){
                $assign_products->where('subsection_id','=',$req->subsection_id);
                $n['subsection'] = Subsection::find($req->subsection_id)->name;
            }
       }

        if($req->str_date){
            $assign_products->where('created_at','>',$req->str_date);
            $n['str_date'] = $req->str_date;
        }
        if($req->end_date){
            $assign_products->where('created_at','<',$req->end_date);
            $n['end_date'] = $req->end_date;
        }
        $n['assign_products'] = $assign_products->get()->groupBy('department_id');

        return view('pages.asset.report.distribution.index',$n);
    }


    public function product(){
        $n['departments'] = Department::where('deleted_by',null)->get();
        return view('pages.asset.report.product',$n);
    }

    public function productFetch(Request $req){
        if($req->department_id != 'common_asset'){
            $this->validate($req,[
                'department_id' => 'nullable|exists:departments,id',
                'product_id' => 'required|exists:products,id',
            ],[],[
                'department_id' =>'Department Name',
                'product_id' =>'Product Name',
            ]);
        }
        $this->validate($req,[
            'product_id' => 'required|exists:products,id',
        ],[],[
            'product_id' =>'Product Name',
        ]);

        return redirect()->route('asset.report.single_product.view',[$req->product_id]);
    }

    public  function damagesearch(){
        $n['departments'] = Department::where('deleted_at', null)->latest()->get();
        $n['sections'] = Section::where('deleted_at', null)->latest()->get();
        $n['subsections'] = Subsection::where('deleted_at', null)->latest()->get();
        return view('pages.asset.report.damage.search',$n);
    }

    public function damageFetch(Request $req){
        $damage_products = AssetDamage::where('deleted_by',null);

        if(isset($req->str_date)){
            $n['str_date'] =$req->str_date;
            $damage_products = $damage_products->where('created_at','>',$req->str_date);
        }

        if(isset($req->end_date)){
            $n['end_date'] =$req->end_date;
            $damage_products = $damage_products->where('created_at','<',$req->end_date);
        }

        $assign_products = AssignProduct::where('deleted_by',null);
        if(isset($req->department_id)){
            $n['department'] = Department::find($req->department_id)->department_name;
            $assign_products = $assign_products->where('department_id',$req->department_id);
        }

        if(isset($req->section_id)){
            $n['section'] = Section::find($req->section_id)->name;
            $assign_products = $assign_products->where('section_id',$req->section_id);
        }

        if(isset($req->subsection_id)){
            $n['subsection'] = AssignProduct::find($req->subsection_id)->name;
            $assign_products = $assign_products->where('subsection_id',$req->subsection_id);
        }
        $assign_products = $assign_products->get();
        foreach($assign_products as $products){
           foreach($products->mainProduct as $main_assign){
            $damage_products =  $damage_products->orWhere('main_assign_id',$main_assign->id);
           }
        }
          $n['damage_products'] = $damage_products->get();
       return view('pages.asset.report.damage.index',$n);
    }
}
