<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\studentInfo;
use App\Models\AdmittedStdAssign;
use App\Models\Semester;

class StudentController extends Controller
{
    public function index($id){
        $this->check_access('view student');
        $n['minfo'] = Semester::with('admittedStdAssign')->where('deleted_at',null)->where('id',$id)->get();

        $n['page_name'] = 'Student Info';
        // dd($n);
        return view('pages.student.index',$n);
    }

}
