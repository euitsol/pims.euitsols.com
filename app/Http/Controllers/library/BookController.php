<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['books'] = Book::where('deleted_at',null)->get();
        return view('pages.library.book.index',$n);
    }

    public function create(){
        $n['categories'] = Category::where('deleted_at',null)->get();
        $n['bookshelves'] = Category::where('deleted_at',null)->get();
        return view('pages.library.book.create',$n);
    }

    public function store(Request $req){
        $this->validate($req,[
            'name' => 'required|string|unique:books,name',
            'author_name' => 'required|string',
            'qty' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
            // 'bookshelf_id' => 'required|integer|exists:bookshelves,id',
        ],[],[
            'name' => 'Book Name',
            'author_name' => 'Author Name',
            'qty' => 'Quantity',
            'category_id' => 'Category',
            'bookshelf_id' => 'Books Name',
        ]);

        $insert = new Book();
        $insert->name = $req->name;
        $insert->author_name = $req->author_name;
        $insert->qty = $req->qty;
        $insert->category_id = $req->category_id;
        // $insert->bookshelf_id = $req->bookshelf_id;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success',"Successfully book - $req->name is added");
        return redirect()->route('library.setup.book.index');
    }

    public function edit($id){
        $n['book'] = Book::findOrFail($id);
        $n['categories'] = Category::where('deleted_at',null)->get();
        $n['bookshelves'] = Category::where('deleted_at',null)->get();
        return view('pages.library.book.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => "required|string|unique:books,name,$req->id,id",
            'author_name' => 'required|string',
            'qty' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
            // 'bookshelf_id' => 'required|integer|exists:bookshelves,id',
        ],[],[
            'name' => 'Book Name',
            'author_name' => 'Author Name',
            'qty' => 'Quantity',
            'category_id' => 'Category',
            'bookshelf_id' => 'Books Name',
        ]);

        $update = Book::findOrFail($req->id);
        $update->name = $req->name;
        $update->author_name = $req->author_name;
        $update->qty = $req->qty;
        $update->category_id = $req->category_id;
        // $update->bookshelf_id = $req->bookshelf_id;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success',"Successfully book - $req->name updated");
        return redirect()->route('library.setup.book.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = Book::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success',"Successfully book - $delete->name deleted");
        }
    }

    public function show($id=null){
        if($id != null){
            $book = Book::with(['created_user','updated_user','deleted_user','created_user','category','bookshelf'])->find($id);
            return response()->json($book);
        }
    }

}
