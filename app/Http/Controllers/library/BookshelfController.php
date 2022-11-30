<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\Bookshelf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookshelfController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['bookshelves'] = Bookshelf::where('deleted_at',null)->latest()->get();
        return view('pages.library.setup.bookshelf.index',$n);
    }

    public function create(){
        return view('pages.library.setup.bookshelf.create');
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:bookshelves,name',
            'capacity' => 'required|integer'
        ],[],[
            'name' => "Bookshelf's Name",
            'capacity' => "Bookshelf's Name",
        ]);

        $insert = new Bookshelf();
        $insert->name = $req->name;
        $insert->capacity = $req->capacity;
        $insert->details = $req->details;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Bookself added successfully');
        return redirect()->route('library.setup.bookshelf.index');
    }

    public function edit($id){
        $n['bookshelf'] = Bookshelf::findOrFail($id);
        return view('pages.library.setup.bookshelf.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => "required|string|unique:bookshelves,name,$req->id,id",
            'capacity' => 'required|integer'
        ],[],[
            'name' => "Bookshelf's Name",
            'capacity' => "Bookshelf's Name",
        ]);

        $update = Bookshelf::findOrFail($req->id);
        $update->name = $req->name;
        $update->capacity = $req->capacity;
        $update->details = $req->details;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Bookself updated successfully');
        return redirect()->route('library.setup.bookshelf.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = Bookshelf::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Bookself deleted successfully');
        }
    }

    public function show($id=null){
        if($id !=null){
            $bookshelf = Bookshelf::with(['created_user', 'updated_user', 'deleted_user'])->find($id);
            return response()->json($bookshelf);
        }
    }

}
