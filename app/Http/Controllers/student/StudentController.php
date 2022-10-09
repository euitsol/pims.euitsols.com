<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\studentInfo;
use App\Models\AdmittedStdAssign;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Session;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }
    public function index($id){
        $this->check_access('view student');
        $n['minfo'] = Semester::with('admittedStdAssign')->where('deleted_at',null)->where('id',$id)->first();
        $n['session']= Session::where('deleted_by','=',null)->latest()->get();
        $n['department']= Department::where('deleted_by','=',null)->get();
        $n['group']= Group::where('deleted_by','=',null)->get();
        $n['shift']= Shift::where('deleted_by','=',null)->get();
        return view('pages.student.index',$n);
    }
    public function show($id)
    {
        $student = studentInfo::with(['created_user', 'updated_user', 'deleted_user', 'department', 'bloodGroup', 'division', 'district', 'academicInfo'])->where('deleted_at', null)->where('id', $id)->first();
        $semester_infos =AdmittedStdAssign::where('student_infos_id',$id)
                                            ->where('deleted_at',null)
                                            ->latest()->get();
        return view('pages.student.admission.registration',[ 'student' => $student,'semester_infos'=>$semester_infos ]);
    }

    //Ajax filter
    public function ajax(Request $req){
        $student_info = AdmittedStdAssign::with('session','studentInfo','semester','group','shift')
        ->where('deleted_at',null)->where('semester_id',$req->semester_id);

        if(isset($req->session_id)){
            $student_info->where('session_id',$req->session_id);
        }
        // if(isset($req->department_id)){
        //     $student_info->where('department_id',$req->department_id);
        // }
        if(isset($req->group_id)){
            $student_info->where('group_id',$req->group_id);
        }
        if(isset($req->shift_id)){
            $student_info->where('shift_id',$req->shift_id);
        }

        $students = $student_info->get();
        foreach($students as $key => $value){
            $departments = $value->departmentAjax($value->studentInfo->departments_id);
            $students[$key]['departments']= $departments;
        }
        return response()->json($students);
    }

}
