<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\studentInfo;
use App\Models\AdmittedStdAssign;
use App\Models\Semester;

class StudentController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }
    public function index($id){
        $this->check_access('view student');
        $n['minfo'] = Semester::with('admittedStdAssign')->where('deleted_at',null)->where('id',$id)->first();

        $n['page_name'] = 'Student Info';
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

}
