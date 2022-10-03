<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\studentInfo;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Session;
use App\Models\AdmittedStdAssign;

class SemesterAssignAdmitStd extends Controller
{
    public function create($id){
        $this->check_access('add admitted_std_accept');

        $n['page_name'] = 'Semester Assign for Admitted Student';
        $n['db_data']= studentInfo::where('deleted_by','=',null)->where('id','=',$id)->first();
        $n['session']= Session::where('deleted_by','=',null)->latest()->get();
        $n['semester']= Semester::where('deleted_by','=',null)->get();
        $n['group']= Group::where('deleted_by','=',null)->get();
        $n['shift']= Shift::where('deleted_by','=',null)->get();
        return view('pages.student.admitted_std_accept.create',$n);
    }

    public function store(Request $req){
        $this->check_access('add admitted_std_accept');
        $rules = [
            "student_id" =>"required|unique:student_infos",
            "session_id" =>"required",
            "semester_id" =>"required",
            "group_id" =>"required",
            "shift_id" =>"required",
        ];
        $msg = [];

        $attributes = [
            "student_id" => 'Student ID',
            "session_id" => 'Session',
            "semester_id" => 'Semester',
            "group_id" => 'Group',
            "shift_id" => 'Shift'
        ];
        $this->validate($req,$rules,$msg,$attributes);

        $check = AdmittedStdAssign::where('deleted_at',null)
                                    ->where('student_infos_id',$req->std_info_id)
                                    ->first();
        if($check != null){
            $student =studentInfo::findOrFail($req->std_info_id);
            $this->message('error', "student ( $student->name ) already assigned");
            return back();
        }
        //insert student id in student info table
        $update_std_info = studentInfo::findOrFail($req->std_info_id);
        $update_std_info->student_id = $req->student_id;
        $update_std_info->status = 1;
        $update_std_info->save();

        //insert information int admitted_std_assing table
        $insert = new AdmittedStdAssign;
        $insert->student_infos_id = $req->std_info_id;
        $insert->session_id = $req->session_id;
        $insert->semester_id = $req->semester_id;
        $insert->group_id = $req->group_id;
        $insert->shift_id = $req->shift_id;
        $insert->save();

        $this->message('success', 'Admitted student assigned successfullly');
        return redirect()->route('student.student-admit.index');
    }
}
