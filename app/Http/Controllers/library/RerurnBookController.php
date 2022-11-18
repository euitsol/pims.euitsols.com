<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AssignBook;
use App\Models\Category;
use App\Models\LibraryStudent;
use App\Models\ReturnBook;
use Illuminate\Http\Request;

class RerurnBookController extends Controller
{
    public function index(){
        $n['return_books'] = ReturnBook::with(['created_user','updated_user','deleted_user'])->where('deleted_by',null)->latest()->get();
        return view('pages.library.retrurn_book.index',$n);
    }

    public function create(){
        $n['students'] = LibraryStudent::where('deleted_by',null)->OrderBy('name')->get();
        $n['categories'] = Category::where('deleted_by',null)->OrderBy('name')->get();
        return view('pages.library.retrurn_book.create',$n);
    }

    public function info(Request $req){
        return response()->json(AssignBook::with(['student','bkdn','bkdn.book','bkdn.book.category','bkdn.book.bookshelf','created_user','updated_user','deleted_user'])->where('std_id',$req->id)->get());
    }
}
