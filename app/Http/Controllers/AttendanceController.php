<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Session;
use App\Models\Department;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SubjectAssign;
use App\Models\TeacherAssign;

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

    public function class(Request $req){
        $this->check_access('add attendance');

        //validation
        $this->validate($req,[
            "session_id" => "required|exists:subject_assigns,session_id",
            "department_id" => "required|exists:subject_assigns,department_id",
            "semester_id" => "required|exists:subject_assigns,semester_id",
            "subject_id" => "required|exists:subject_assigns,subject_id",
            "shift_id" => "required|exists:teacher_assigns,shift_id",
            "group_id" => "required|exists:teacher_assigns,group_id",
            "teacher_id" => "required|exists:teachers,id",
        ],[],[
            "session_id"=> "Session",
            "department_id"=> "Department",
            "semester_id"=> "Semester",
            "subject_id"=> "Subject",
            "shift_id"=> "Shift",
            "group_id"=> "Group",
            "teacher_id"=> "Teacher"
        ]);
            $session_id = $req->session_id;
            $department_id = $req->department_id;
            $semester_id = $req->semester_id;
            $subject_id = $req->subject_id;
            $shift_id = $req->shift_id;
            $group_id = $req->group_id;
            $teacher_id = $req->teacher_id;

            $n['classes'] = Subject::with(['credit'])->where('deleted_at',null)
                            ->where('id',$req->subject_id)
                            ->get();
            // $n['session']= Session::where('deleted_by','=',null)->latest()->get();
            // $n['department']= Department::where('deleted_by','=',null)->get();
            // $n['semester']= Semester::where('deleted_by','=',null)->get();
            // $n['shift']= Shift::where('deleted_by','=',null)->get();
            // $n['group']= Group::where('deleted_by','=',null)->get();

            $n['session']= Session::where('id','=',$session_id)
                            ->where('deleted_by','=',null)
                            ->latest()->first();
            $n['department']= Department::where('id','=',$department_id)
                                        ->where('deleted_by','=',null)
                                        ->first();
            $n['semester']= Semester::where('id','=',$semester_id)
                            ->where('deleted_by','=',null)->first();
            $n['shift']= Shift::where('id','=',$shift_id)
                        ->where('deleted_by','=',null)->first();
            $n['group']= Group::where('id','=',$group_id)
                        ->where('deleted_by','=',null)->first();
            $n['subject']= Subject::where('id','=',$subject_id)
                        ->where('deleted_by','=',null)->first();
            $n['teacher']= Teacher::where('id','=',$teacher_id)
                        ->where('deleted_by','=',null)->first();

            return view('pages.attendance.class',$n);
    }
}
