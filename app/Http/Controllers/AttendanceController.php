<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Session;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\SubjectAssign;

class AttendanceController extends Controller
{
    public function index(){
        $atttendance = Attendance::where('deleted_at',null)->get();
        echo "This is't necessary";
    }

    public function create(){
        $this->check_access('add student');
        $n['session']= Session::where('deleted_by','=',null)->latest()->get();
        $n['department']= Department::where('deleted_by','=',null)->get();
        $n['semester']= Semester::where('deleted_by','=',null)->get();
        $n['shift']= Shift::where('deleted_by','=',null)->get();
        $n['group']= Group::where('deleted_by','=',null)->get();
        $n['subject']= Group::where('deleted_by','=',null)->get();
        return view('pages.attendance.index',$n);
    }
    public function ajax(Request $request){
        $teachers= Teacher::where('deleted_by','=',null)->where('departments_id','=',$request->department_id)->latest()->get();
        return response()->json($teachers);
    }

    public function subjectAssignFetch(Request $req){
        $subject = SubjectAssign::with(['subject'])->where('deleted_by','=',null)
                                ->where('session_id',$req->session_id)
                                ->where('department_id',$req->department_id)
                                ->where('semester_id',$req->semester_id)
                                ->latest()->get();
        return response()->json($subject);
    }
}
