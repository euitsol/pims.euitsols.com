<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\studentInfo;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Session;

class SemesterAssignAdmitStd extends Controller
{
    public function index(){
        $n['page_name'] = 'Semester Assign for Admitted Student';
        $n['db_data']= studentInfo::where('deleted_by','=',null)->first();
        $n['semester']= Semester::where('deleted_by','=',null)->get();
        $n['shift']= Shift::where('deleted_by','=',null)->get();
        $n['group']= Group::where('deleted_by','=',null)->get();
        $n['session']= Session::where('deleted_by','=',null)->get();
        return view('pages.setup.semester_assign_admitted_student.index',$n);
    }
}
