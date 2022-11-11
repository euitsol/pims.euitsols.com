<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['categories'] = Category::where('deleted_at',null)->latest()->get();
        return view('pages.library.setup.category.index',$n);
    }

    public function create(){
        return view('pages.library.setup.category.create');
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:categories,name'
        ],[],['name' => 'Category Name']);

        $insert = new Category();
        $insert->name = $req->name;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Successfully category created');
        return redirect()->route('library.setup.category.index');
    }

    public function edit($id){
        $n['category'] = Category::findOrFail($id);
        return view('pages.library.setup.category.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => "required|string|unique:categories,name,$req->id,id"
        ],[],['name' => 'Category Name']);

        $update = Category::findOrFail($req->id);
        $update->name = $req->name;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Successfully category updated');
        return redirect()->route('library.setup.category.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = Category::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Successfully deleted');
        }
    }

    public function show($id = null){
        if($id !=null){
            $category =Category::with(['created_user','updated_user','deleted_user'])->find($id);
            return response()->json($category);
        }
    }

}
