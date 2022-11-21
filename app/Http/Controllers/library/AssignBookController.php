<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\AssignBook;
use App\Models\AssignBookBkdn;
use App\Models\LibraryStudent;
use App\Models\studentInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignBookController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['assigned_books'] = AssignBook::with(['bkdn','created_user','updated_user','deleted_user','student'])->where('deleted_by',null)->latest()->get();
        return view('pages.library.book_assign.index',$n);
    }

    public function create(){
        $n['students'] = LibraryStudent::where('deleted_by',null)->OrderBy('name')->get();
        $n['categories'] = Category::where('deleted_by',null)->OrderBy('name')->get();
        return view('pages.library.book_assign.create',$n);
    }



    public function store(Request $req){
        // dd($req->all());
        $this->validate($req,[
            'std_id' => 'required|integer|exists:student_infos,id',
            'book.*.book_id' => 'required|integer|exists:books,id',
            'book.*.return_date' => 'required|date',
        ],[],[
            'std_id' => 'Student ID',
            'book.*.book_id' => 'Book ID',
        ]);


        foreach($req->book as $key => $val){
            $insert = new AssignBook();
            $insert->std_id = $req->std_id;
            $insert->book_id = $val['book_id'];
            $insert->assign_date = Carbon::now()->toDateTimeString();
            $insert->return_date =$val['return_date'];
            $insert->qty = $val['qty'];
            $insert->created_by = Auth::user()->id;
            $insert->save();

            //update books quantity
            $update_qty = Book::find($val['book_id']);
            $update_qty->qty = $update_qty->qty - $val['qty'];
            $update_qty->save();
        }

        $this->message('success','Successfully book assigned');
        return redirect()->back();
    }

    public function edit($id){

        $n['assign_book'] = AssignBook::with(['student','bkdn','bkdn.book','bkdn.book.category','bkdn.book.bookshelf','created_user','updated_user','deleted_user'])->find($id);
        $n['students'] = LibraryStudent::where('deleted_by',null)->OrderBy('name')->get();
        $n['categories'] = Category::where('deleted_by',null)->OrderBy('name')->get();
        $n['books'] = Book::where('deleted_by',null)->OrderBy('name')->get();

        return view('pages.library.book_assign.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'std_id' => 'required|integer|exists:student_infos,id',
            'book.*.book_id' => 'required|integer|exists:books,id',
            'assig_book_id' => 'exists:assign_books,id',
            'return_date' => 'required',
        ],[],[
            'std_id' => 'Student ID',
            'book.*.book_id' => 'Book ID',
        ]);

        $insert = AssignBook::find($req->assig_book_id);
        $insert->std_id = $req->std_id;
        $insert->assign_date = Carbon::now()->toDateTimeString();
        $insert->return_date = $req->return_date;
        $total_book = 0;
        foreach($req->book as $key => $val){
           $total_book += $val['qty'];
        }
        $insert->total_book = $total_book;
        $insert->updated_by = Auth::user()->id;
        $insert->save();

       $delete = AssignBookBkdn::where('assign_book_id',$req->assig_book_id)->delete();

        foreach($req->book as $value){
            $insert_bkdn = new AssignBookBkdn();
            $insert_bkdn->assign_book_id = $insert->id;
            $insert_bkdn->book_id = $value['book_id'];
            $insert_bkdn->qty = $value['qty'];
            $insert->updated_by = Auth::user()->id;
            $insert_bkdn->save();

            //update books quantity
            $update_qty = Book::find($value['book_id']);
            $update_qty->qty = $update_qty->qty - $value['qty'];
            $update_qty->save();
        }

        $this->message('success','Successfully updated');
        return redirect()->route('library.book_assign.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = AssignBook::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Successfully deleted');
        }
    }

    public function show($id = null){
        if($id !=null){
            $student =AssignBook::with(['student','bkdn','bkdn.book','bkdn.book.category','bkdn.book.bookshelf','created_user','updated_user','deleted_user'])->find($id);
            return response()->json($student);
        }
    }

    //student information show in create page by ajax on change
    public function info(Request $req){
        if($req->id){

         $student = LibraryStudent::find($req->id);
         return response()->json($student);
        }
     }
     public function book_info(Request $req){
        if($req->id){
         $books = Book::where('category_id',$req->id)->where('deleted_by',null)->OrderBy('name')->get();
         return response()->json($books);
        }

     //    return $req->id;
     }

     public function single_book_fetch(Request $req){
         $book = Book::with(['bookshelf','category'])->Find($req->id);
         return response()->json($book);
     }

    public function residentialStdShow(Request $req){
        $student = studentInfo::Find($req->id);
        return response()->json($student);
    }



}
