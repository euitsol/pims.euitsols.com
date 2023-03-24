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
use ILluminate\Support\Facades\Rule;

class SubjectAssignController extends Controller
{
    //index function
   public function index(){
        $this->check_access('view subject-ssign');
        $n['query'] = SubjectAssign::where('deleted_at',null)->orderBy('session_id')->get()->groupBy(['session_id','department_id','semester_id']);
        // dd($n['query']);

        $n['data']= SubjectAssign::with(['session','department','subject','semester','created_user'])->where('deleted_at',null)->get();
        return view('pages.setup.subject_assign.index',$n);
   }


   //create function
   public function create(){
        $this->check_access('add subject-ssign');

        $n['session'] = Session::where('deleted_at',null)->get();
        $n['department'] = Department::where('deleted_at',null)->get();
        $n['subject'] = Subject::where('deleted_at',null)->get();
        $n['semester'] = Semester::where('deleted_at',null)->get();
        return view('pages.setup.subject_assign.create',$n);
   }

   //store function
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

            foreach($request->subject_id as $subject_id){
                // dd($subject_id);
                $exists = SubjectAssign::where('session_id',$request->session_id)->where('department_id',$request->department_id)
                ->where('semester_id',$request->semester_id)->where('subject_id',$subject_id)->where('deleted_at','!=',null)->first();

                $query = SubjectAssign::where('session_id',$request->session_id)->where('department_id',$request->department_id)
                        ->where('semester_id',$request->semester_id)->where('subject_id',$subject_id)->where('deleted_at',null)->first();

                if($exists != null){
                    $exists->deleted_at = null;
                    $exists->save();
                    $id= $exists->id;

                }
                elseif($query != null){
                    $this->message('error','Subject '.$query->subject->name.' already assigned');
                    return redirect()->back()->withInput();
                }else{
                    $data['subject_id'] = $subject_id;
                    $save = SubjectAssign::create($data);
                    $id = $save->id;
                }
            }

            $this->message('success','Successfully Subject assigned');
            return redirect()->route('teacher-assign.create',$id);
    }


    //ajax function
    public function ajax(Request $request){
            $department_id =  $request->department_id;
            $session_id = $request->session_id;
            $semester_id =  $request->semester_id;
            $id = [$session_id,$department_id,$semester_id];
            $subject = Subject::where('department_id',$department_id)->where('deleted_at', null)->latest()->get();

            foreach($subject as $key => $value){
                $result = $value->subjectIsAssign($session_id,$semester_id,$department_id);
                $subject[$key]["result"]=$result;
            }
        return response()->json($subject);
   }


   //edit function
   public function edit($id){
        $this->check_access('update subject-ssign');

        $n['data'] = SubjectAssign::with(['session','department','subject','semester','created_user'])->where('id',$id)->first();
        $n['session'] = Session::where('deleted_at',null)->get();
        $n['department'] = Department::where('deleted_at',null)->get();
        $n['subject'] = Subject::where('deleted_at',null)->where('department_id',$n['data']->department_id)->get();
        $n['semester'] = Semester::where('deleted_at',null)->get();


        return view('pages.setup.subject_assign.edit',$n);
   }


   //Update function
   public function update(Request $request){
        $this->check_access('update subject-ssign');


        $query = SubjectAssign::find($request->id);
        $session_id = $query->session_id;
        $department_id = $query->department_id;
        $semester_id = $query->semester_id;
        $subject_id = $query->subject_id;
       $n = SubjectAssign::where('session_id',$session_id)
                        ->where('department_id',$department_id)
                        ->where('semester_id',$semester_id)
                        ->where('deleted_at',null)
                        ->get();
         foreach($n as $delete){
            $delete->delete();
         }
    //    validation
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

        foreach($request->subject_id as $subject_id){

            $exists = SubjectAssign::where('session_id',$request->session_id)
                                    ->where('department_id',$request->department_id)
                                    ->where('semester_id',$request->semester_id)
                                    ->where('subject_id',$subject_id)
                                    ->where('deleted_at','!=',null)
                                    ->first();

            $query = SubjectAssign::where('session_id',$request->session_id)
                                    ->where('department_id',$request->department_id)
                                    ->where('semester_id',$request->semester_id)
                                    ->where('subject_id',$subject_id)
                                    ->where('deleted_at',null)
                                    ->first();

            if($exists != null){
                $exists->deleted_at = null;
                $exists->save();
            }
            elseif($query != null){
                $this->message('error','Subject '.$query->subject->name.' already assigned');
                return redirect()->back()->withInput();
            }else{
                $data['subject_id'] = $subject_id;
                SubjectAssign::create($data);
            }
        }

        $this->message('success','Successfully Update');
        return redirect()->route('subject-assign.index');
   }


   //destroy function
   public function destroy($id){
        $this->check_access('delete subject-ssign');

        $query = SubjectAssign::find($id);
        $session_id = $query->session_id;
        $department_id = $query->department_id;
        $semester_id = $query->semester_id;
        $subject_id = $query->subject_id;
       $n = SubjectAssign::where('session_id',$session_id)
                        ->where('department_id',$department_id)
                        ->where('semester_id',$semester_id)
                        ->where('deleted_at',null)
                        ->get();
         foreach($n as $delete){
            $delete->deleted_at = Carbon::Now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
         }

        $this->message('success','Successfully Deleted');
        return redirect()->route('subject-assign.index');

   }
}
