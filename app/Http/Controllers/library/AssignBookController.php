<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\AssignBook;
use App\Models\Department;
use App\Models\LibraryMember;
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
        $n['students'] = LibraryMember::where('deleted_by',null)->OrderBy('name')->get();
        $n['categories'] = Category::where('deleted_by',null)->OrderBy('name')->get();
        $n['departments'] = Department::where('deleted_by',null)->OrderBy('department_name')->get();
        return view('pages.library.book_assign.create',$n);
    }



    public function store(Request $req){
        // dd($req->all());
        $this->validate($req,[
            'std_id' => 'required|integer|exists:library_members,id',
            'book.*.book_id' => 'required|integer|exists:books,id',
            'book.*.return_date' => 'required|date',
        ],[],[
            'std_id' => 'Student ID',
            'book.*.book_id' => 'Book ID',
        ]);


        foreach($req->book as $key => $val){
            $date_array = explode('/',$val['return_date']);
            $date = $date_array[2].'-'.$date_array[0].'-'.$date_array[1];
            // dd($date);
            $insert = new AssignBook();
            $insert->std_id = $req->std_id;
            $insert->book_id = $val['book_id'];
            $insert->assign_date = date('Y-m-d');
            $insert->return_date =$date;
            $insert->qty = $val['qty'];
            $insert->created_by = Auth::user()->id;
            $insert->save();

            //update books quantity
            $update_qty = Book::find($val['book_id']);
            $update_qty->qty = $update_qty->qty - $val['qty'];
            $update_qty->save();
        }

        $this->message('success','Book assigned successfully');
        return redirect()->back();
    }

    public function edit($id){

        $n['assign_book'] = AssignBook::with(['student','book','book.category','book.bookshelf','book.category.department','created_user','updated_user','deleted_user'])->find($id);
        $n['students'] = LibraryMember::where('deleted_by',null)->OrderBy('name')->get();
        $n['categories'] = Category::where('deleted_by',null)->OrderBy('name')->get();
        $n['books'] = Book::where('deleted_by',null)->OrderBy('name')->get();
        $n['departments'] = Department::where('deleted_by',null)->OrderBy('department_name')->get();
        $n['categories'] = Category::where('deleted_by',null)->OrderBy('name')->get();
        $n['books'] = Book::where('deleted_by',null)->OrderBy('name')->get();

        return view('pages.library.book_assign.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'std_id' => 'required|integer|exists:library_students,id',
            'book.*.book_id' => 'required|integer|exists:books,id',
            'return_date' => 'required',
        ],[],[
            'std_id' => 'Student ID',
            'book.*.book_id' => 'Book ID',
        ]);

        $update = AssignBook::findOrFail($req->id);
        $update->std_id = $req->std_id;
        $update->book_id = $req->book_id;

        // Update book qty
        $book_update = Book::findOrFail($req->book_id);
        $book_update->qty = $book_update->qty +$update->qty - $req->qty;
        $book_update->save();

        // Update assign book table
        $update->qty = $req->qty;
        $update->return_date = $req->return_date;
        $update->updated_by = Auth::user()->id;
        $update->save();

        $this->message('success','Assigned book updated successfully');
        return redirect()->back();
    }

    public function destroy($id =null){
        if($id != null){
            $delete = AssignBook::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Assigned book deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $student =AssignBook::with(['student','book','book.category','book.bookshelf','book.category.department','created_user','updated_user','deleted_user'])->find($id);
            return response()->json($student);
        }
    }

    //student information show in create page by ajax on change
    public function info(Request $req){
        if($req->id){
         $n['student'] = LibraryMember::with('assignBook')->find($req->id);

         return response()->json($n);
        }
     }
     public function book_info(Request $req){
        if($req->id){
         $books = Book::where('category_id',$req->id)->where('deleted_by',null)->OrderBy('name')->get();
         return response()->json($books);
        }
     }

     public function single_book_fetch(Request $req){
         $book = Book::with(['bookshelf','category'])->Find($req->id);
         return response()->json($book);
     }

    public function residentialStdShow(Request $req){
        $student = studentInfo::Find($req->id);
        return response()->json($student);
    }


    public function categoryFetch($id){
        return response()->json(Category::where('departments_id',$id)->get());
    }

public function transection(Request $req){
    $a = AssignBook::with(['student','book','book.category','book.bookshelf','book.category.department','created_user','updated_user','deleted_user'])
                    ->where('deleted_by',null)
                    ->where('std_id',$req->id);
    $d = clone $a;
    $r = clone $a;

    $n['assigned'] = $a->where('status','0')
                        ->where('return_date','>', Carbon::now())
                        ->get();

    $n['dew'] = $d->where('status','0')
                    ->where('return_date','<', Carbon::now())
                    ->get();

    $n['returned'] = $r->where('status','!=','0')
                        ->get();

    return response()->json($n);
}

}
