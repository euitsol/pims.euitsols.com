<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectAssign;
use App\Models\Group;
use App\Models\Shift;
use App\Models\Subject;
use App\Models\TeacherAssign;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TeacherAssignController extends Controller
{
    //Create function for create page show for data store
    public function create($id)
    {
        $this->check_access('add teacher_assign');
        $data_fetch = SubjectAssign::findOrFail($id);
        $session_id = $data_fetch->session_id;
        $department_id = $data_fetch->department_id;
        $semester_id = $data_fetch->semester_id;

        $n['data'] = SubjectAssign::with(['teacherAssign'])
            ->where('session_id', $session_id)
            ->where('department_id', $department_id)
            ->where('semester_id', $semester_id)
            ->where('deleted_at', null)->orderby('subject_id')
            ->get();

        $n['sds'] = $n['data']->first();

        $n['group'] = Group::where('deleted_at', null)
            ->get();
        $n['shift'] = Shift::where('deleted_at', null)
            ->get();
        $n['teacher'] = Teacher::where('deleted_at', null)->where('departments_id',$data_fetch->department_id)->get();

        return view('pages.setup.teacher_assign.create', $n);
    }


    //store function for store information
    public function store(Request $req)
    {
        $this->check_access('add teacher_assign');
        // dd($req->all());

        foreach ($req->teacher_assign as $key => $teacher_assign) {
            if ($key == 0) {
                $s_id = 0;
            }

            if ($s_id != $teacher_assign['subject_assign_id']) {
                $delete = TeacherAssign::where('subject_assign_id', $teacher_assign['subject_assign_id'])->delete();
            }

            $s_id = $teacher_assign['subject_assign_id'];


            $teacher_assign_check = TeacherAssign::where('subject_assign_id', $teacher_assign['subject_assign_id'])
                ->where('group_id', $teacher_assign['group_id'])
                ->where('shift_id', $teacher_assign['shift_id'])
                ->where('deleted_at', null)->first();

            if ($teacher_assign_check == null) {
                // dd($teacher_assign);
                $insert = new TeacherAssign;
                $insert->subject_assign_id = $teacher_assign['subject_assign_id'];

                $insert->teacher_id = $teacher_assign['teacher_id'];
                $insert->group_id = $teacher_assign['group_id'];
                $insert->shift_id = $teacher_assign['shift_id'];

                $insert->save();
            } else {

                $this->message('error', 'Subject "'.$teacher_assign_check->subjectAssign->subject->name.'" is already assigned with same teacher, group and shift');
                return back();
            }
        }
        $this->message('success', 'Teachers Successfully Assigned');
        return redirect()->route('teacher-assign.index');
    }

    //Show all information
    public function index()
    {
        $n['minfo'] = TeacherAssign::with('created_user','updated_user','deleted_user','subjectAssign','group','shift')->where('deleted_at', null)->get()->groupBy(['subject_assign_id']);
        // dd($n['minfo']);
        return view('pages.setup.teacher_assign.index', $n);
    }


    // Mask Delete
    public function destroy($id)
    {
        $this->check_access('delete teacher_assign');

        $delete = TeacherAssign::find($id);
        $delete->deleted_by = Auth::user()->id;
        $delete->deleted_at = Carbon::now()->toDateTimeString();
        $delete->save();
        $this->message('success', 'Teacher "' . $delete->subjectAssign->subject->name . '" deleted successfully');
        return redirect()->route('teacher-assign.index');
    }

    public function assign($id){
        $this->check_access('add teacher_assign');

        // $data_fetch = TeacherAssign::findOrFail($id);
        // $subject_assign_id = $data_fetch->subject_assign_id;

        $n['minfo'] = TeacherAssign::where('subject_assign_id', $id)
                    ->where('deleted_at', null)
                    ->get();

                    // dd($n);

        $n['group'] = Group::where('deleted_at', null)
            ->get();
        $n['shift'] = Shift::where('deleted_at', null)
            ->get();
        $n['teacher'] = Teacher::where('deleted_at', null)->get();

        return view('pages.setup.teacher_assign.assign', $n);
    }

    public function assignStore(Request $req){
        $this->check_access('add teacher_assign');

        foreach($req->teacher_assign as $key => $teacher_assign){

            if($key === 0){
                TeacherAssign::where('subject_assign_id', $req->subject_assign_id)->delete();
            }

            $teacher_assign_check = TeacherAssign::where('subject_assign_id', $req->subject_assign_id)
                ->where('group_id', $teacher_assign['group_id'])
                ->where('shift_id', $teacher_assign['shift_id'])
                ->where('teacher_id', $teacher_assign['teacher_id'])
                ->where('deleted_at', null)->first();
            if($teacher_assign_check==null){
                $insert = new TeacherAssign;
                $insert->subject_assign_id = $req->subject_assign_id;
                $insert->teacher_id = $teacher_assign['teacher_id'];
                $insert->group_id = $teacher_assign['group_id'];
                $insert->shift_id = $teacher_assign['shift_id'];
                $insert->save();
            }else {

                $this->message('error', 'Subject "'.$teacher_assign_check->subjectAssign->subject->name.'" is already assigned with same teacher, group and shift');
                return back();
            }
        }
        $this->message('success', 'Teachers Successfully Assigned');
        return redirect()->route('teacher-assign.index');
    }
}
