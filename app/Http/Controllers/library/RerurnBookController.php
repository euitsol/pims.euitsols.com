<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AssignBook;
use App\Models\Book;
use App\Models\Category;
use App\Models\LibraryMember;
use Illuminate\Http\Request;

class RerurnBookController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function create(){
        $n['students'] = LibraryMember::where('deleted_by',null)->OrderBy('name')->get();
        $n['categories'] = Category::where('deleted_by',null)->OrderBy('name')->get();
        return view('pages.library.retrurn_book.create',$n);
    }

    public function show($id){
        return AssignBook::with(['student','book','book.category','book.bookshelf','created_user','updated_user','deleted_user','book.category.department'])->find($id);
    }

    public function info(Request $req){
        return response()->json(AssignBook::with(['student','book','book.category','book.bookshelf','created_user','updated_user','deleted_user','book.category.department'])
                                            ->where('std_id',$req->id)
                                            ->where('status','0')
                                            ->get());
    }

    public function update($id){
       $update = AssignBook::findOrFail($id);
       if($update->return_date >=  date('Y-m-d')){
           $update->status = '1';
       }else{
        $update->status = '-1';
       }
       $update->returned_date =date('Y-m-d');
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

    public function payment(Request $req){
            echo 'Payment'.$req->id;
    }
}
