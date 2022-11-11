<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AdmittedStdAssign;
use App\Models\LibraryStudent;
use App\Models\studentInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryStudentController extends Controller
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
        $n['students'] = AdmittedStdAssign::with(['studentInfo'])->latest()->get();
        return view('pages.library.student.create',$n);
    }

    public function store(Request $req){
        // dd($req->permanent_add);
        $this->validate($req,[
            'name' => 'required|string',
            'std_id' => 'integer|exists:student_infos,id',
            'dob' => 'required',
            'phone' => 'required|numeric',//|unique:library_students,phone
            'present_add' => 'required',
            'permanent_add' => 'required',
            'ec_name' => 'required',
            'ec_phone' => 'required|numeric',
        ],[],[
            'name' => 'Student Name',
            'std_id' => 'Student ID',
            'dob' => "Student's date of birth",
            'phone' =>"Student's Phone",
            'present_add' => 'Present Address',
            'permanent_add' => 'Permanent Address',
            'ec_name' => 'Emergency Contact (Name)',
            'ec_phone' => 'Emergency Contact (Phone)',
        ]);

        $insert = new LibraryStudent();
        $insert->std_id = $req->std_id;
        $insert->name = $req->name;
        $insert->dob = $req->dob;
        $insert->phone = $req->phone;
        $insert->present_address = $req->present_add;
        $insert->permanent_address = $req->permanent_add;
        $insert->ec_name = $req->ec_name;
        $insert->ec_phone = $req->ec_phone;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Successfully student added');
        return redirect()->route('library.student.index');
    }

    public function edit($id){
        $n['student'] = LibraryStudent::findOrFail($id);
        return view('pages.library.student.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'name' => 'required|string',
            // 'std_id' => 'integer|nullable|exists:student_infos,id',
            'dob' => 'required',
            'phone' => "required|numeric",//|unique:library_students,phone,$req->id,id
            'present_add' => 'required',
            'permanent_add' => 'required',
            'ec_name' => 'required',
            'ec_phone' => 'required|numeric',
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

        $update = LibraryStudent::findOrFail($req->id);
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
            $student =LibraryStudent::with(['created_user','updated_user','deleted_user'])->find($id);
            return response()->json($student);
        }
    }

    public function residentialStdShow(Request $req){
        $student = studentInfo::Find($req->id);
        return response()->json($student);
    }

}
