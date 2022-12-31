<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Department;
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
        $n['departments'] = Department::where('deleted_by',null)->get();
        return view('pages.library.setup.category.create',$n);
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:categories,name',
            'department_id' => 'required|exists:departments,id',
        ],[],['name' => 'Category Name','department_id' => "Department's Name"]);
        $insert = new Category();
        $insert->departments_id = $req->department_id;
        $insert->name = $req->name;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Category added successfully');
        return redirect()->route('library.setup.category.index');
    }

    public function edit($id){
        $n['departments'] = Department::where('deleted_by',null)->get();
        $n['category'] = Category::with('department')->findOrFail($id);
        return view('pages.library.setup.category.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => "required|string|unique:categories,name,$req->id,id",
            'department_id' => 'required|exists:departments,id',
        ],[],['name' => 'Category Name','department_id' => "Department's Name"]);

        $update = Category::findOrFail($req->id);
        $update->departments_id = $req->department_id;
        $update->name = $req->name;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Category updated successfully');
        return redirect()->route('library.setup.category.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = Category::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Category deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $category =Category::with(['created_user','updated_user','deleted_user','department'])->find($id);
            return response()->json($category);
        }
    }

}
