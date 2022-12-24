<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use App\Models\AssignProduct;
use App\Models\Department;
use App\Models\MainAssignProduct;
use App\Models\MoreProduct;
use App\Models\Product;
use App\Models\Section;
use App\Models\Subcategory;
use App\Models\Subsection;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignProductController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $n['departments'] = Department::where('deleted_at', null)->latest()->get();
        $n['sections'] = Section::where('deleted_at', null)->latest()->get();
        $n['subsections'] = Subsection::where('deleted_at', null)->latest()->get();
        $n['categories'] = AssetCategory::where('deleted_at', null)->latest()->get();
        $n['subcategories'] = Subcategory::where('deleted_at', null)->latest()->get();
        return view('pages.asset.assign-product.index', $n);
    }

    public function create(Request $req)
    {
        $n['categories'] = AssetCategory::where('deleted_at', null)->latest()->get();
        $n['brands'] = AssetBrand::where('deleted_at', null)->latest()->get();
        $n['units'] = AssetUnit::where('deleted_at', null)->latest()->get();
        $n['departments'] = Department::where('deleted_at', null)->latest()->get();
        $n['suppliers'] = Supplier::where('deleted_at', null)->latest()->get();
        return view('pages.asset.product.create', $n);
    }

    public function store(Request $req)
    {

        $insert = new AssignProduct();
        $insert->department_id = $req->department_id;
        $insert->section_id = $req->section_id;
        $insert->subsection_id = $req->subsection_id;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        return response($insert->id);
    }

    public function mainStore(Request $req)
    {
        $this->validate($req,[
            'product.*.product_id' => "required|exists:products,id",
            'product.*.cat_id' => "required|exists:categories,id",
            'product.*.subcat_id' => "required|exists:subcategories,id",
            'product.*.supplier_id' => "required|exists:suppliers,id",
            'product.*.qty' => "required|string",
        ]);
        foreach($req->product as $key =>$val){

            $insert = new MainAssignProduct();
            $insert->assign_product_id  = $req->assign_product_id ;
            $insert->product_id = $val['product_id'];
            $insert->cat_id  = $val['cat_id'] ;
            $insert->subcat_id   = $val['subcat_id']  ;
            $insert->supplier_id   = $val['supplier_id']  ;
            $insert->qty   = $val['qty'] ;
            
            //quantity update in products table
            $update = Product::find($val['product_id']);
            $update->qty =  $update->qty - $val['qty'];
            $update->save();

            $insert->created_by = Auth::user()->id;
            $insert->save();
        }

        return redirect()->route('asset.assign.product.index')->with('success','Product successfully assigned');
    }


    public function edit($id)
    {
        $n['categories'] = AssetCategory::where('deleted_at', null)->latest()->get();
        $n['brands'] = AssetBrand::where('deleted_at', null)->latest()->get();
        $n['units'] = AssetUnit::where('deleted_at', null)->latest()->get();
        $n['departments'] = Department::where('deleted_at', null)->latest()->get();
        $n['product'] = Product::findOrFail($id);
        return view('pages.asset.product.edit', $n);
    }

    public function update(Request $req)
    {
        $this->validate($req, [
            'cat_id' => 'required|exists:asset_categories,id',
            'subcat_id' => 'required|exists:subcategories,id',
            'brand_id' => 'required|exists:asset_brands,id',
            'department_id' => 'nullable|exists:departments,id',
            'unit_id' => 'required|exists:asset_units,id',
            'name' => 'required|string',
            'qty' => 'required|integer',
            'total_price' => 'integer',
        ], [], [
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
        $this->message('success', 'Product updated successfully');
        return redirect()->route('asset.product.index');
    }

    public function destroy($id = null)
    {
        if ($id != null) {
            $delete = Product::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success', 'Product deleted successfully');
        }
    }

    public function show($id = null)
    {
        if ($id != null) {
            $product = Product::with(['created_user', 'updated_user', 'deleted_user', 'category', 'subcategory', 'brand', 'unit', 'department'])->find($id);
            return response()->json($product);
        }
    }
    public function subcatFetch(Request $req)
    {
        if ($req->id) {
            $subcategory = Subcategory::where('cat_id', $req->id)->get();
            return response()->json($subcategory);
        }
    }

    public function moreProduct($id = null)
    {
        if ($id) {
            $n['product'] = Product::find($id);
            $n['more_products'] = MoreProduct::where('product_id', $id)->get();
            $n['suppliers'] = Supplier::where('deleted_at', null)->latest()->get();
            return view('pages.asset.product.add-more', $n);
        }
    }

    public function moreProductStore(Request $req)
    {
        $this->validate($req, [
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'qty' => 'required|integer',
            'warranty' => 'required',
            'total_price' => 'required',
        ], [
            'product_id' => 'Product Name',
            'supplier_id' => 'Shop Name',
            'qty' => 'Quantity',
        ]);

        $insert = new MoreProduct();
        $insert->product_id = $req->product_id;
        $insert->supplier_id = $req->supplier_id;
        $insert->quantity = $req->qty;
        $insert->warranty = $req->warranty;
        $insert->total_price = $req->total_price;
        $insert->created_by = Auth::user()->id;
        $insert->save();

        //update products table
        $update = Product::find($req->product_id);
        $update->qty =  $update->qty + $req->qty;
        $update->total_price = $update->total_price + $req->total_price;
        $update->save();

        $this->message('success', 'Product added successfully');
        return redirect()->route('asset.product.index');
    }

    public function productFetch(Request $req){

        $product = call_user_func(array('\\App\\Models\\'.$req->model,  "with"),$req->with_arr);
        $product = $product->get();
        $product = $product->where('deleted_by',null);

        foreach($req->arr as $key => $val){
            $val = (int)$val;
            $product = $product->where($key,$val);
        }
        return response()->json($product);
    }
}
