<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\LibraryStudent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Studentcontroller extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['students'] = LibraryStudent::with(['created_user','updated_user','deleted_user'])->where('deleted_at',null)->latest()->get();
        return view('pages.library.student.index',$n);
    }

    public function create(){
        return view('pages.library.student.create');
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:categories,name'
        ],[],['name' => 'Category Name']);

        $insert = new LibraryStudent();
        $insert->name = $req->name;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Successfully category created');
        return redirect()->route('library.student.index');
    }

    public function edit($id){
        $n['category'] = LibraryStudent::findOrFail($id);
        return view('pages.library.student.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => "required|string|unique:categories,name,$req->id,id"
        ],[],['name' => 'Category Name']);

        $update = LibraryStudent::findOrFail($req->id);
        $update->name = $req->name;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Successfully category updated');
        return redirect()->route('library.student.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = LibraryStudent::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Successfully deleted');
        }
    }

    public function show($id = null){
        if($id !=null){
            $category =LibraryStudent::with(['created_user','updated_user','deleted_user'])->find($id);
            return response()->json($category);
        }
    }

}
