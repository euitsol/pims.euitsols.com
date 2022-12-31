<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\AssetBrand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetBrandController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['brands'] = AssetBrand::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.brand.index',$n);
    }

    public function create(){
        return view('pages.asset.setup.brand.create');
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:asset_brands,name',
        ],[],['name' => 'Brand Name']);
        $insert = new AssetBrand();
        $insert->name = $req->name;
        $insert->status = 1;
        $insert->created_by = Auth::user()->id;
        $insert->save();

        if($req->hasFile('img') && $req->file('img')->isValid()){
            $insert->addMediaFromRequest('img')->toMediaCollection('asset-brand-img');
        }

        $this->message('success','Brand added successfully');
        return redirect()->route('asset.setup.brand.index');
    }

    public function edit($id){
        $n['brand'] = AssetBrand::findOrFail($id);
        return view('pages.asset.setup.brand.edit',$n);
    }

    public function update(Request $req){

        $this->validate($req,[
            'name' => "required|string|unique:asset_brands,name,$req->id,id",
        ],[],['name' => 'Brand Name',]);

        $update = AssetBrand::findOrFail($req->id);
        $update->name = $req->name;
        $update->img = 'img';
        $update->status = 1;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Brand updated successfully');
        return redirect()->route('asset.setup.brand.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = AssetBrand::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Brand deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $brand =AssetBrand::with(['created_user','updated_user','deleted_user'])->find($id);
            return response()->json($brand);
        }
    }
}
