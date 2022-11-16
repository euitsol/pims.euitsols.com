<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\BookAssign;
use App\Models\LibraryStudent;
use App\Models\studentInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookAssignController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['assigned_books'] = BookAssign::with(['created_user','updated_user','deleted_user'])->where('deleted_by',null)->latest()->get();
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
            'std_id' => 'integer|exists:student_infos,id',
            'book_id' => 'integer|exists:books,id',
        ],[],[
            'std_id' => 'Student ID',
            'book_id' => 'Book ID',
        ]);

        $insert = new BookAssign();
        $insert->std_id = $req->std_id;
        $insert->book_id = $req->book_id;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Successfully book assigned');
        return redirect()->route('library.book_assign.index');
    }

    public function edit($id){
        $n['student'] = BookAssign::findOrFail($id);
        return view('pages.library.book_assign.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => 'required|string|max:255',
            // 'std_id' => 'integer|nullable|exists:student_infos,id',
            'dob' => 'required',
            'phone' => "required|string|digits:11",//|unique:library_students,phone,$req->id,id
            'present_add' => 'required|max:255',
            'permanent_add' => 'required|max:255',
            'ec_name' => 'nullable|max:255',
            'ec_phone' => 'nullable|string|digits:11',
        ],[],[
            'name' => 'Student Name',
            // 'std_id' => 'Student ID',
            'dob' => "Student's date of birth",
            'phone' =>"Student's Phone",
            'present_add' => 'Present Address',
            'permanent_add' => 'Permanent Address',
            'ec_name' => 'Emergency Contact (Name)',
            'ec_phone' => 'Emergency Contact (Phone)',
        ]);

        $update = BookAssign::findOrFail($req->id);
        $update->std_id = $req->std_id;
        $update->name = $req->name;
        $update->dob = $req->dob;
        $update->phone = $req->phone;
        $update->present_address = $req->present_add;
        $update->permanent_address = $req->permanent_add;
        $update->ec_name = $req->ec_name;
        $update->ec_phone = $req->ec_phone;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Successfully student updated');
        return redirect()->route('library.book_assign.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = BookAssign::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Successfully deleted');
        }
    }

    public function show($id = null){
        if($id !=null){
            $student =BookAssign::with(['student','book','created_user','updated_user','deleted_user'])->find($id);
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
