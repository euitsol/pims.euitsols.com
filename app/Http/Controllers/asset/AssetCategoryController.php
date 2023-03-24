<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetCategoryController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
//     category index file

    public function index(){
        $n['categories'] = AssetCategory::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.category.index',$n);
    }

    public function create(){
        return view('pages.asset.setup.category.create');
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:asset_categories,name',
        ],[],['name' => 'Category Name']);
        $insert = new AssetCategory();
        $insert->name = $req->name;
        $insert->status = 1;
        $insert->created_by = Auth::user()->id;
        $insert->save();

        if($req->hasFile('img') && $req->file('img')->isValid()){
            $insert->addMediaFromRequest('img')->toMediaCollection('asset-category-img');
        }

        $this->message('success','Category added successfully');
        return redirect()->route('asset.setup.category.index');
    }

    public function edit($id){
        $n['category'] = AssetCategory::findOrFail($id);
        return view('pages.asset.setup.category.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => "required|string|unique:categories,name,$req->id,id",
        ],[],['name' => 'Category Name',]);

        $update = AssetCategory::findOrFail($req->id);
        $update->name = $req->name;
        $update->img = 'img';
        $update->status = 1;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Category updated successfully');
        return redirect()->route('asset.setup.category.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = AssetCategory::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Category deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $category =AssetCategory::with(['created_user','updated_user','deleted_user'])->find($id);
            return response()->json($category);
        }
    }
}
