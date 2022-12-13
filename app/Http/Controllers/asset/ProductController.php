<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\AssetBrand;
use App\Models\AssetCategory;
use App\Models\AssetUnit;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['products'] = Product::where('deleted_at',null)->latest()->get();
        return view('pages.asset.product.index',$n);
    }

    public function create(){
        $n['categories'] = AssetCategory::where('deleted_at',null)->latest()->get();
        $n['brands'] = AssetBrand::where('deleted_at',null)->latest()->get();
        $n['units'] = AssetUnit::where('deleted_at',null)->latest()->get();
        $n['departments'] = Department::where('deleted_at',null)->latest()->get();
        return view('pages.asset.product.create',$n);
    }

    public function store(Request $req){
        $this->validate($req,[
            'cat_id' => 'required|exists:asset_categories,id',
            'subcat_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:asset_brands,id',
            'department_id' => 'required|exists:departments,id',
            'unit_id' => 'required|exists:asset_units,id',
            'name' => 'required|string',
            'qty' => 'required|integer',
            'description' => 'string',
            'total_price' => 'integer',
        ],[],[
            'cat_id' => 'Category Name',
            'subcat_id' => 'Subcategory Name',
            'brand_id' => 'Brand Name',
            'department_id' => 'Department Name',
            'unit_id' => 'Unit Name',
            'name' => 'Product Name',
            'qty' => 'Quantity',
        ]);
        $insert = new Product();
        $insert->cat_id = $req->cat_id;
        $insert->subcat_id = $req->subcat_id;
        $insert->brand_id = $req->brand_id;
        $insert->department_id = $req->department_id;
        $insert->unit_id = $req->unit_id;
        $insert->name = $req->name;
        $insert->qty = $req->qty;
        $insert->description = $req->description;
        $insert->total_price = $req->total_price;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Product added successfully');
        return redirect()->route('asset.product.index');
    }

    public function edit($id){
        $n['categories'] = AssetCategory::where('deleted_at',null)->latest()->get();
        $n['brands'] = AssetBrand::where('deleted_at',null)->latest()->get();
        $n['units'] = AssetUnit::where('deleted_at',null)->latest()->get();
        $n['departments'] = Department::where('deleted_at',null)->latest()->get();
        $n['product'] = Product::findOrFail($id);
        return view('pages.asset.product.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'cat_id' => 'required|exists:asset_categories,id',
            'subcat_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:asset_brands,id',
            'department_id' => 'required|exists:departments,id',
            'unit_id' => 'required|exists:asset_units,id',
            'name' => 'required|string',
            'qty' => 'required|integer',
            'description' => 'string',
            'total_price' => 'integer',
        ],[],[
            'cat_id' => 'Category Name',
            'subcat_id' => 'Subcategory Name',
            'brand_id' => 'Brand Name',
            'department_id' => 'Department Name',
            'unit_id' => 'Unit Name',
            'name' => 'Product Name',
            'qty' => 'Quantity',
        ]);

        $update = Product::findOrFail($req->id);
        $update->cat_id = $req->cat_id;
        $update->subcat_id = $req->subcat_id;
        $update->brand_id = $req->brand_id;
        $update->department_id = $req->department_id;
        $update->unit_id = $req->unit_id;
        $update->name = $req->name;
        $update->qty = $req->qty;
        $update->description = $req->description;
        $update->total_price = $req->total_price;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Product updated successfully');
        return redirect()->route('asset.product.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = Product::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Product deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $product =Product::with(['created_user','updated_user','deleted_user','category','subcategory','brand','unit','department'])->find($id);
            return response()->json($product);
        }
    }
    public function subcatFetch(Request $req){
        if($req->id){
            $subcategory =Subcategory::where('cat_id',$req->id)->get();
            return response()->json($subcategory);
        }
    }
}

