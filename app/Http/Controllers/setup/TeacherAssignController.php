<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubjectAssign;
use App\Models\Group;
use App\Models\Shift;
use App\Models\Subject;
use App\Models\TeacherAssign;
use Carbon\Carbon;

class TeacherAssignController extends Controller
{
    //Create function for create page show for data store
   public function create($id){
    $data_fetch = SubjectAssign::find($id);
    $session_id = $data_fetch->session_id;
    $department_id = $data_fetch->department_id;
    $semester_id = $data_fetch->semester_id;
     $n['data'] =SubjectAssign::where('session_id',$session_id)
                                ->where('department_id',$department_id)
                                ->where('semester_id',$semester_id)
                                ->where('deleted_at',null)
                                ->latest()->get();

     $n['sds'] =SubjectAssign::where('session_id',$session_id)
                                ->where('department_id',$department_id)
                                ->where('semester_id',$semester_id)
                                ->where('deleted_at',null)
                                ->first();

     $n['group'] =Group::where('deleted_at',null)
                        ->get();
     $n['shift'] =Shift::where('deleted_at',null)
                        ->get();
    $n['teacher'] = ['Teacher-1','Teacher-2'];

     return view('pages.setup.teacher_assign.create',$n);
   }

   //store function for store information
   public function store(Request $req){
    // dd($req->subject_assign);

    $i= 0;
        foreach($req->subjec_assign_id as $sa){

                foreach($sa as $data){
                    $insert = new TeacherAssign;
                    $insert->teacher_id = $data['teacher_id'];
                    $insert->group_id = $data['group'];
                    $insert->shift_id = $data['shift_id'];
                    $insert->subject_assign_id = $req->subject_assign[$i];
                    $insert->created_by = auth()->user()->id;
                    $insert->save();
                }
                $i++;
        }
        $this->message('success','Subjects Successfully Assigned');
                        return back();

   }
}
