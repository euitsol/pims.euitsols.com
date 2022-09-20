<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Department;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\SubjectAssign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use ILluminate\Support\Facades\DB;

class SubjectAssignController extends Controller
{
   public function index(){

    $this->check_access('view subject-ssign');
    $n['data']= SubjectAssign::with(['session','department','subject','semester','created_user'])->where('deleted_at',null)->get();
    return view('pages.setup.subject_assign.index',$n);
   }

   public function create(){
    $this->check_access('add subject-ssign');

    $n['session'] = Session::where('deleted_at',null)->get();
    $n['department'] = Department::where('deleted_at',null)->get();
    $n['subject'] = Subject::where('deleted_at',null)->get();
    $n['semester'] = Semester::where('deleted_at',null)->get();
    return view('pages.setup.subject_assign.create',$n);
   }

   public function store(Request $request){
    $this->check_access('store subject-ssign');

        $rules = [
            'session_id' => 'required|exists:sessions,id',
            'department_id' => 'required|exists:departments,id',
            'subject_id.*' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
        ];
        $msg = [];
        $attributes = [
                'session_id' => 'Session',
                'department_id' => 'Session',
                'subject_id.*' => 'Subject',
                'semester_id' => 'Semester',
        ];
        $this->validate($request,$rules,$msg,$attributes);
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        // dd($request->all());
        foreach($request->subject_id as $subject_id){
                $data['subject_id'] = $subject_id;
                SubjectAssign::create($data);
        }

        $this->message('success','Successfully Subject assigned');
        return redirect()->route('subject-assign.index');
   }

   //ajax
   public function ajax(Request $request){
   $department_id =  $request->department_id;
//    $subject_id =  $request->subject_id;
//    $session_id =  $request->session_id;
    $subject = Subject::where('department_id',$department_id)->where('deleted_at',null)->latest()->get();
    // foreach($subject as $key => $value){
    //     $result = $value->subjectIsAssign();
    //     $subject[$key]["result"]=$result;
    // }
     return $subject;
   }

   //Edit page show
   public function edit($id){
    $this->check_access('update subject-ssign');
    $n['session'] = Session::where('deleted_at',null)->get();
    $n['department'] = Department::where('deleted_at',null)->get();
    $n['subject'] = Subject::where('deleted_at',null)->get();
    $n['semester'] = Semester::where('deleted_at',null)->get();
    $n['data'] = SubjectAssign::with(['session','department','subject','semester','created_user'])->where('id',$id)->first();

    return view('pages.setup.subject_assign.edit',$n);
   }

   //Update
   public function update(Request $request){
    $this->check_access('update subject-ssign');
    $rules = [
        'session_id' => 'required|exists:sessions,id',
        'department_id' => 'required|exists:departments,id',
        'subject_id' => 'required|exists:subjects,id',
        'semester_id' => 'required|exists:semesters,id',
    ];
    $msg = [];
    $attributes = [
            'session_id' => 'Session',
            'department_id' => 'Session',
            'subject_id' => 'Subject',
            'semester_id' => 'Semester',
    ];
    $this->validate($request,$rules,$msg,$attributes);

        $update = SubjectAssign::find($request->id);
        $update->session_id = $request->session_id;
        $update->department_id = $request->department_id;
        $update->subject_id = $request->subject_id;
        $update->semester_id = $request->semester_id;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Successfully Update');
    return redirect()->route('subject-assign.index');
   }

   public function destroy($id){
        $this->check_access('delete subject-ssign');
        $delete = SubjectAssign::find($id);
        $delete->deleted_at = Carbon::Now()->toDateTimeString();
        $delete->deleted_by = Auth::user()->id;
        $delete->save();
        $this->message('success','Successfully Deleted');
        return redirect()->route('subject-assign.index');

   }
}
