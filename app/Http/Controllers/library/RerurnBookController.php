<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AssignBook;
use App\Models\Book;
use App\Models\Category;
use App\Models\LibraryStudent;
use App\Models\ReturnBook;
use Illuminate\Http\Request;

class RerurnBookController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['return_books'] = ReturnBook::with(['created_user','updated_user','deleted_user'])->where('deleted_by',null)->latest()->get();
        return view('pages.library.retrurn_book.index',$n);
    }

    public function create(){
        $n['students'] = LibraryStudent::where('deleted_by',null)->OrderBy('name')->get();
        $n['categories'] = Category::where('deleted_by',null)->OrderBy('name')->get();
        return view('pages.library.retrurn_book.create',$n);
    }

    public function show($id){
        return AssignBook::with(['student','book','book.category','book.bookshelf','created_user','updated_user','deleted_user'])->find($id);
    }

    public function info(Request $req){
        return response()->json(AssignBook::with(['student','book','book.category','book.bookshelf','created_user','updated_user','deleted_user'])
                                            ->where('std_id',$req->id)
                                            ->where('status','0')
                                            ->get());
    }

    public function return($id){
       $update = AssignBook::findOrFail($id);
       $update->status = '1';

       $book_update = Book::find($update->book_id);
       $book_update->qty = $book_update->qty + $update->qty;
       $book_update->save();
       $check = $update->save();
       if($check){
        return 1;
       }else{
        return 0;
       }

    }
}
