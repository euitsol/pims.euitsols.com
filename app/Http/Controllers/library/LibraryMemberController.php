<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AdmittedStdAssign;
use App\Models\LibraryMember;
use App\Models\studentInfo;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryMemberController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['students'] = LibraryMember::with(['created_user','updated_user','deleted_user'])->where('deleted_at',null)->latest()->get();
        return view('pages.library.student.index',$n);
    }

    public function create(){
        $n['students'] = AdmittedStdAssign::with(['studentInfo'])->latest()->get();
        $n['teachers'] = Teacher::where('deleted_by',null)->OrderBy('name')->get();
        $n['member'] = LibraryMember::where('deleted_by',null)->latest()->first();
         if(isset($n['member']->member_id)){
            $n['member_id'] =  $n['member']->member_id+1;
        };
        return view('pages.library.student.create',$n);
    }

    public function store(Request $req){
        // dd($req->permanent_add);
        $this->validate($req,[
            'name' => 'required|string|max:255',
            'member_id' => 'required|string',
            'dob' => 'required',
            'phone' => 'required|string|digits:11',//|unique:library_students,phone
            'present_add' => 'required|max:255',
            'permanent_add' => 'required|max:255',
            'ec_name' => 'nullable|max:255',
            'ec_phone' => 'nullable|string|digits:11',
        ],[],[
            'name' => 'Student Name',
            'member_id' => 'Member ID',
            'dob' => " date of birth",
            'phone' =>"hone",
            'present_add' => 'Present Address',
            'permanent_add' => 'Permanent Address',
            'ec_name' => 'Emergency Contact (Name)',
            'ec_phone' => 'Emergency Contact (Phone)',
        ]);
        $insert = new LibraryMember();
        $insert->std_id = $req->std_id;
        $insert->teacher_id = $req->teacher_id;

        $insert->member_id = $req->member_id;
        $insert->name = $req->name;
        $insert->dob = $req->dob;
        $insert->phone = $req->phone;
        $insert->present_address = $req->present_add;
        $insert->permanent_address = $req->permanent_add;
        $insert->ec_name = $req->ec_name;
        $insert->ec_phone = $req->ec_phone;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Member created successfully');
        return redirect()->route('library.member.index');
    }

    public function edit($id){
        $n['student'] = LibraryMember::findOrFail($id);
        return view('pages.library.student.edit',$n);
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

        $update = LibraryMember::findOrFail($req->id);
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
        $this->message('success','Member updated successfully');
        return redirect()->route('library.student.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = LibraryMember::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Member deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $student =LibraryMember::with(['created_user','updated_user','deleted_user'])->find($id);
            return response()->json($student);
        }
    }

    public function residentialStdFetch(Request $req){
        $student = studentInfo::Find($req->id);
        return response()->json($student);
    }

    public function rdtTeacherFetch(Request $req){
        $teacher = Teacher::Find($req->id);
        return response()->json($teacher);
    }

    public function idCheck(Request $req){
        if(LibraryMember::where('member_id',$req->member_id)->first()){
            return true;
        }else{
            return false;
        }
    }

}
