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
                    ->where('deleted_at', null)
                    ->get();

        $n['sds'] = $n['data']->first();

        $n['group'] = Group::where('deleted_at', null)
            ->get();
        $n['shift'] = Shift::where('deleted_at', null)
            ->get();
        $n['teacher'] = Teacher::where('deleted_at', null)->get();

        // $check = TeacherAssign::with(['subjectAssign','group','shift'])->where('subject_assign_id',$id)->where('deleted_at',null)->first();
        // if(($check!=null)){
        //     $group_id = $check->group_id;
        //     $shift_id = $check->shift_id;
        //     $teacher_id = $check->teacher_id;
        //     $n['exist_mifo'] = TeacherAssign::with(['subjectAssign','group','shift'])
        //             ->where('subject_assign_id',$id)
        //             ->where('group_id',$group_id)
        //             ->where('shift_id',$shift_id)
        //             ->where('deleted_at',null)
        //             ->get();

        //     return view('pages.setup.teacher_assign.exist_create', $n);
        //    }

        return view('pages.setup.teacher_assign.create', $n);
    }


    //store function for store information
    public function store(Request $req)
    {
        dd($req->all());

        $this->check_access('add teacher_assign');
        // TeacherAssign::where('subject_assign_id', )->delete();
        foreach ($req->subjec_assign_id as $key => $sa) {


            foreach ($sa as $data) {
                // dd($data);
                $insert = new TeacherAssign;
                $insert->teacher_id = $data['teacher_id'];
                $insert->group_id = $data['group'];
                $insert->shift_id = $data['shift_id'];
                $insert->subject_assign_id = $req->subject_assign[$key];
                $insert->created_by = auth()->user()->id;
                $insert->save();
            }

        }
        $this->message('success', 'Subjects Successfully Assigned');
        return back();
    }

    //Show all information
    public function index()
    {
        $n['minfo'] = TeacherAssign::where('deleted_at', null)->groupBy(['subject_assign_id'])->get();
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
        $this->message('success', 'Teacher "'.$delete->subjectAssign->subject->name.'" deleted successfully');
        return redirect()->route('teacher-assign.index');
    }
}
