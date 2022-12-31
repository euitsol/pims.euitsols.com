<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassContent;
use App\Models\StdAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassContentController extends Controller
{

    public function __construct() {
        return $this->middleware('auth');
    }

    function index($attendance_id,$class){
        $std_attendance = StdAttendance::where('attendance_id',$attendance_id)->where('class',$class)->first();
        $n['class_content'] = ClassContent::with('stdAttendance')->where('deleted_at',null)->where('std_attendance_id',$std_attendance->id)->first();
        return view('pages.class_content.index',$n);
    }

    function create($attendance_id, $class)
    {
        $n['minfo'] = StdAttendance::with(['created_user', 'studentInfo', 'attendances'])
            ->where('attendance_id', $attendance_id)
            ->where('class', $class)->first();
        $n['class_content'] = ClassContent::where('std_attendance_id',$n['minfo']->id)->first();
        $n['class'] = $class;
        $n['attendance_id'] = $attendance_id;

        return view('pages.class_content.create', $n);
    }

    function store(Request $req)
    {

        //Validation
        $this->validate($req, [
            'class_content' => 'required'
        ]);

        //Store class content
        $exist = ClassContent::where('std_attendance_id',$req->std_attendance_id)->first();
        if($exist){
            $exist->std_attendance_id = $req->std_attendance_id;
            $exist->class_content = $req->class_content;
            $exist->created_by = Auth::user()->id;
            $exist->save();
        }else{
            $insert = new ClassContent();
            $insert->std_attendance_id = $req->std_attendance_id;
            $insert->class_content = $req->class_content;
            $insert->created_by = Auth::user()->id;
            $insert->save();
        }

        return redirect()->route('class_content.index',[$req->attendance_id,$req->class])->with('success', 'Successfully class Content Assigned');
    }


}
