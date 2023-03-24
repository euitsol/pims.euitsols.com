<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['subcategories'] = Subcategory::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.subcategory.index',$n);
    }

    public function create(){
        $n['categories'] = AssetCategory::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.subcategory.create',$n);
    }

    public function store(Request $req){
        $this->validate($req,[
            'cat_id' => 'required|exists:asset_categories,id',
            'name' => 'required|string|unique:subcategories,name',
        ],[],['name' => 'Subcategory Name']);
        $insert = new Subcategory();
        $insert->cat_id = $req->cat_id;
        $insert->name = $req->name;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Subcategory added successfully');
        return redirect()->route('asset.setup.subcategory.index');
    }

    public function edit($id){
        $n['categories'] = AssetCategory::where('deleted_at',null)->latest()->get();
        $n['subcategory'] = Subcategory::findOrFail($id);
        return view('pages.asset.setup.subcategory.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'cat_id' => 'required|exists:asset_categories,id',
            'name' => "required|string|unique:subcategories,name,$req->id,id",
        ],[],['name' => 'Subcategory Name','cat_id' => 'Category Name']);

        $update = Subcategory::findOrFail($req->id);
        $update->cat_id = $req->cat_id;
        $update->name = $req->name;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Subcategory updated successfully');
        return redirect()->route('asset.setup.subcategory.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = Subcategory::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Subcategory deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $subcategory =Subcategory::with(['created_user','updated_user','deleted_user','category'])->find($id);
            return response()->json($subcategory);
        }
    }
}
