<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassContent;
use App\Models\StdAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassContentController extends Controller
{
    function index(){
        $n['class_content'] = ClassContent::where('deleted_at',null)->get();
        return view('pages.class_content.index',$n);
    }
    function create($attendance_id, $class)
    {
        $n['minfo'] = StdAttendance::with(['created_user', 'studentInfo', 'attendances'])
            ->where('attendance_id', $attendance_id)
            ->where('class', $class)->first();
        $n['class'] = $class;
        return view('pages.class_content.create', $n);
    }

    function store(Request $req)
    {

        //Validation
        $this->validate($req, [
            'class_content' => 'required'
        ]);

        //Store class content
        $insert = new ClassContent();
        $insert->std_attendance_id = $req->std_attendance_id;
        $insert->class = $req->class;
        $insert->class_content = $req->class_content;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        return redirect()->route('class_content.index')->with('success', 'Successfully class Content Assigned');
    }


}
