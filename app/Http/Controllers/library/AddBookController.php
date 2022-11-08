<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AddBook;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddBookController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['books'] = AddBook::where('deleted_at',null)->get();
        return view('pages.library.add_book.index',$n);
    }

    public function create(){
        $n['categories'] = Category::where('deleted_at',null)->get();
        $n['bookshelves'] = Category::where('deleted_at',null)->get();
        return view('pages.library.add_book.create',$n);
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:add_books,name',
            'author_name' => 'required|string',
            'qty' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
            // 'bookshelf_id' => 'required|integer|exists:bookshelves,id',
        ],[],[
            'name' => 'Book Name',
            'author_name' => 'Author Name',
            'qty' => 'Quantity',
            'category_id' => 'Category',
            // 'bookshelf_id' => 'Books Name',
        ]);

        $insert = new AddBook();
        $insert->name = $req->name;
        $insert->author_name = $req->author_name;
        $insert->qty = $req->qty;
        $insert->category_id = $req->category_id;
        // $insert->bookshelf_id = $req->bookshelf_id;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Successfully Book is added');
        return redirect()->route('library.setup.add_book.index');
    }

    public function edit($id){
        $n['AddBook'] = AddBook::findOrFail($id);
        return view('pages.library.AddBook.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => "required|string|unique:add_books,name,$req->id,id"
        ],[],['name' => 'AddBook Name']);

        $update = AddBook::findOrFail($req->id);
        $update->name = $req->name;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Successfully AddBook updated');
        return redirect()->route('library.setup.AddBook.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = AddBook::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            return back()->with('success','Successfully deleted');
        }
    }

}
