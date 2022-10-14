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

    public function subjectFetch(Request $req){
        $this->check_access('add attendance');
            $session_id = $req->session_id;
            $department_id = $req->department_id;
            $semester_id = $req->semester_id;
            $subject_id = $req->subject_id;
            $shift_id = $req->shift_id;
            $group_id = $req->group_id;
            $teacher_id = $req->teacher_id;

            // $teacher = TeacherAssign::where('deleted_at',null)
            //             ->where('teacher_id',$teacher_id)
            //             ->where('group_id',$group_id)
            //             ->where('shift_id',$shift_id)
            //             ->first();
            //             // dd($teacher);
            // $n['subjects'] = SubjectAssign::with(['subject'])->where('deleted_at',null)
            //                 ->where('id',$teacher->subject_assign_id)
            //                 ->get();
            $n['classes'] = Subject::with(['credit'])->where('deleted_at',null)
                            ->where('id',$req->subject_id)
                            ->get();
            $n['session']= Session::where('deleted_by','=',null)->latest()->get();
            $n['department']= Department::where('deleted_by','=',null)->get();
            $n['semester']= Semester::where('deleted_by','=',null)->get();
            $n['shift']= Shift::where('deleted_by','=',null)->get();
            $n['group']= Group::where('deleted_by','=',null)->get();

            return view('pages.attendance.index',$n);
    }
}
