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
use Carbon\Carbon;
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
            'product.*.supplier_id' => "required|exists:suppliers,id",
            'product.*.qty' => "required|string",
        ]);
        foreach($req->product as $key =>$val){

            $insert = new MainAssignProduct();
            $insert->assign_product_id  = $req->assign_product_id ;
            $insert->product_id = $val['product_id'];
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

    public function productFetch(Request $req){
        $product = call_user_func(array('\\App\\Models\\'.$req->model,  "with"),$req->with_arr);
        $product = $product->get();
        $product = $product->where('deleted_by',null);
        if(isset($req->arr)){
            foreach($req->arr as $key => $val){
                $val = (int)$val;
                $product = $product->where($key,$val);
            }
        }
        // if(isset($req->condition['orWhere'])){
        //     foreach($req->condition['orWhere'] as $key => $val){
        //         $product = $product->orWhere($key,$val);
        //     }
        // }
        return response()->json($product);
    }

    public function edit($id){
        $n['main_assign_product'] = MainAssignProduct::with(['assignProduct','assignProduct.department','product'])->find($id);
        return view('pages.asset.assign-product.edit',$n);
    }

    public function update(Request $req){
        $this->validate($req,[
            'qty' => 'required|integer',
            'supplier_id' => 'required|exists:suppliers,id',
        ],[],[
            'qty' => 'Quantity',
        ]);

        $update = MainAssignProduct::find($req->id);

         //update product qty
         $product = Product::find($req->product_id);
         $product->qty = $product->qty + $update->qty - $req->qty;
         $product->save();

        $update->qty = $req->qty;
        $update->supplier_id = $req->supplier_id;
        $update->updated_by = Auth::user()->id;
        $update->save();
        return redirect()->route('asset.report.single_product.view',[$req->product_id])->with('success','Assigned product updated successfully');
    }

    public function destroy($id = null){
        if($id){
            $delete = MainAssignProduct::find($id);
            $product_id =  $delete->product_id;
            $update_qty = Product::find($product_id);
            $update_qty->qty = $update_qty->qty + $delete->qty;
            $update_qty->save();
            $delete->deleted_at= Carbon::now()->toDateTimeString();
            $delete->deleted_by= Auth::user()->id;
            $delete->save();
            return redirect()->back()->with('success','Assigned product deleted successfully');
        }
    }

}
