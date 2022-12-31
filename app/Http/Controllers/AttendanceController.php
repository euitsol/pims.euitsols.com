<?php

namespace App\Http\Controllers;

use App\Models\AdmittedStdAssign;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Session;
use App\Models\Department;
use App\Models\StdAttendance;
use App\Models\SubjectAssign;
use App\Models\TeacherAssign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function filter()
    {
        $n['session'] = Session::where('deleted_by', '=', null)->latest()->get();
        $n['department'] = Department::where('deleted_by', '=', null)->get();
        $n['semester'] = Semester::where('deleted_by', '=', null)->get();
        $n['shift'] = Shift::where('deleted_by', '=', null)->get();
        $n['group'] = Group::where('deleted_by', '=', null)->get();
        return view('pages.attendance.filter', $n);
    }

    public function subjectFetch(Request $req)
    {
        $subject = SubjectAssign::with(['subject'])->where('deleted_by', '=', null)
            ->where('session_id', $req->session_id)
            ->where('department_id', $req->department_id)
            ->where('semester_id', $req->semester_id)
            ->latest()->get();
        return response()->json($subject);
    }

    public function teacherFetch(Request $request)
    {

        $subject_assign_id = SubjectAssign::where('deleted_by', '=', null)->where('subject_id', '=', $request->subject_id)->latest()->first();
        $teachers = TeacherAssign::with('teacher')
            ->where('deleted_by', '=', null)
            ->where('subject_assign_id', '=', $subject_assign_id->id)
            ->where('group_id', '=', $request->group_id)
            ->where('shift_id', '=', $request->shift_id)
            ->latest()->get();
        return response()->json($teachers);
    }

    public function filterStore(Request $req)
    {
        //validation
        $this->validate($req, [
            "session_id" => "required|exists:subject_assigns,session_id",
            "department_id" => "required|exists:subject_assigns,department_id",
            "semester_id" => "required|exists:subject_assigns,semester_id",
            "subject_id" => "required|exists:subject_assigns,subject_id",
            "shift_id" => "required|exists:teacher_assigns,shift_id",
            "group_id" => "required|exists:teacher_assigns,group_id",
            "teacher_id" => "required|exists:teachers,id",
        ], [], [
            "session_id" => "Session",
            "department_id" => "Department",
            "semester_id" => "Semester",
            "subject_id" => "Subject",
            "shift_id" => "Shift",
            "group_id" => "Group",
            "teacher_id" => "Teacher"
        ]);
        $session_id = $req->session_id;
        $department_id = $req->department_id;
        $semester_id = $req->semester_id;
        $subject_id = $req->subject_id;
        $shift_id = $req->shift_id;
        $group_id = $req->group_id;
        $teacher_id = $req->teacher_id;

        $check = Attendance::where('deleted_by', null)
            ->where('session_id', $session_id)
            ->where('departments_id', $department_id)
            ->where('semester_id', $semester_id)
            ->where('subject_id', $subject_id)
            ->where('shift_id', $shift_id)
            ->where('group_id', $group_id)
            ->where('teacher_id', $teacher_id)
            ->first();

        if ($check == null) {
            $insert = new Attendance();
            $insert->session_id = $session_id;
            $insert->departments_id = $department_id;
            $insert->semester_id = $semester_id;
            $insert->subject_id = $subject_id;
            $insert->shift_id = $shift_id;
            $insert->group_id = $group_id;
            $insert->teacher_id = $teacher_id;
            $insert->created_by = Auth::user()->id;
            $insert->save();
            $id = $insert->id;
        } else {
            $id = $check->id;
        }

        return redirect()->route('attendance.class', $id);
    }

    public function class($id)
    {
        $n['minfo'] = Attendance::with(['created_user', 'session', 'department', 'semester', 'subject', 'group', 'shift', 'teacher'])->findOrFail($id);
        return view('pages.attendance.class', $n);
    }

    public function create($id, $class)
    {
        $n['minfo'] = Attendance::with(['created_user', 'session', 'department', 'semester', 'subject', 'group', 'shift', 'teacher'])->find($id);
        $n['students'] = AdmittedStdAssign::with('studentInfo')
                        ->where('session_id', $n['minfo']->session_id)
                        ->where('semester_id', $n['minfo']->semester_id)
                        ->where('group_id', $n['minfo']->group_id)
                        ->where('shift_id', $n['minfo']->shift_id)
                        ->get();
        $n['class'] = $class;
        $n['attendance_taken'] = StdAttendance::where('class', $class)
            ->where('attendance_id', $id)
            ->first();
        return view('pages.attendance.create', $n);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            "date" => "required|date",
            'student.*.id' => 'required'
        ]);
        $date_check = StdAttendance::where('attendance_id', $req->attendance_id)
                    ->where('date', $req->date)
                    ->where('class', $req->class)
                    ->first();

        // if ($date_check) {

            $present = 0;
            $absent = 0;
            foreach ($req->student as $student) {
                if ($student['attendance'] == 1) {
                    $present++;
                }
                if ($student['attendance'] == -1) {
                    $absent++;
                }
                $check = StdAttendance::where('student_infos_id', $student['id'])
                    ->where('attendance_id', $req->attendance_id)
                    ->where('class', $req->class)
                    ->first();


                if ($check === null) {
                    $insert = new StdAttendance();
                    $insert->student_infos_id = $student['id'];
                    $insert->attendance_id = $req->attendance_id;
                    $insert->class = $req->class;
                    $insert->date = $req->date;
                    $insert->attendance = $student['attendance'];
                    $insert->created_by = Auth::user()->id;
                    $insert->save();
                } else {
                    $check->student_infos_id = $student['id'];
                    $check->attendance_id = $req->attendance_id;
                    $check->class = $req->class;
                    $check->date = $req->date;
                    $check->attendance = $student['attendance'];
                    $check->updated_at = Carbon::now()->toDateTimeString();
                    $check->updated_by = auth()->user()->id;
                    $check->save();
                }
            }
        // } else {
        //     return back()->with('error',"$req->date already taken,Please select another date");
        // }
        $total_std = $present + $absent;

        return redirect()->route('class_content.create', [$req->attendance_id, $req->class])->with('success', "Class-$req->class; Date: $req->date; Total students: $total_std; Present: $present;  Absent: $absent");
    }
}
