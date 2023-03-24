<?php

namespace App\Http\Controllers;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Session;
use App\Models\Department;
use App\Models\ExamSearch;
use App\Models\ExamType;
use App\Models\ExamShift;
use App\Models\ExamCreate;
use App\Models\ExamSchedule;
use App\Models\SubjectAssign;
use App\Models\ExamSubject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ExamManagementController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $n['session'] = Session::where('deleted_by', '=', null)->latest()->get();
        $n['department'] = Department::where('deleted_by', '=', null)->latest()->get();
        $n['semester'] = Semester::where('deleted_by', '=', null)->latest()->get();

        return view('pages.exam-management.create-exam.index', $n);
    }

    public function search(Request $request){
        $this->validate($request, [
            "session_id" => "required|exists:sessions,id",
            "department_id" => "required|exists:departments,id",
            "semester_id" => "required|exists:semesters,id",
        ], [], [
            "session_id" => "Session",
            "department_id" => "Department",
            "semester_id" => "Semester",
        ]);

        $exam_search = ExamSearch::firstOrCreate([
                                                    'session_id' => $request->session_id,
                                                    'department_id' => $request->department_id,
                                                    'semester_id' => $request->semester_id,

                                                ], [
                                                    'session_id' => $request->session_id,
                                                    'department_id' => $request->department_id,
                                                    'semester_id' => $request->semester_id,
                                                    'created_by' => Auth::user()->id,
                                                    'created_at' => Carbon::now(),
                                                ]);

        return redirect()->route('em.create.show', $exam_search->id);
    }

    public function show($id){
        $exam_search = ExamSearch::with(['session', 'department', 'semester', 'created_user', 'updated_user'])->findOrFail($id);
        $shifts = Shift::where('deleted_by',null)->latest()->get();
        $groups = Group::where('deleted_by',null)->latest()->get();
        $exam_creates = ExamCreate::with(['search', 'type', 'schedules', 'created_user', 'updated_user'])->where('deleted_by',null)->get();
        $subjects = SubjectAssign::with(['subject'])
                                    ->where('session_id', $exam_search->session->id)
                                    ->where('department_id', $exam_search->department->id)
                                    ->where('deleted_by',null)
                                    ->latest()->get();

        return view('pages.exam-management.create-exam.show', ['subjects' => $subjects, 'exam_creates' => $exam_creates, 'exam_search' => $exam_search, 'shifts' => $shifts, 'groups' => $groups]);
    }

    public function add($id){
        $exam_search = ExamSearch::with(['session', 'department', 'semester', 'created_user', 'updated_user'])->findOrFail($id);
        $exam_types = ExamType::where('deleted_by',null)->latest()->get();
        $exam_shifts = ExamShift::where('deleted_by',null)->latest()->get();
        $shifts = Shift::where('deleted_by',null)->latest()->get();
        $groups = Group::where('deleted_by',null)->latest()->get();
        $subjects = SubjectAssign::with(['subject'])
                                   ->where('session_id', $exam_search->session->id)
                                   ->where('department_id', $exam_search->department->id)
                                   ->where('deleted_by',null)
                                   ->latest()->get();

        return view('pages.exam-management.create-exam.create', ['subjects' => $subjects, 'exam_search' => $exam_search, 'exam_types' => $exam_types, 'shifts' => $shifts, 'groups' => $groups, 'exam_shifts' => $exam_shifts]);
    }

    public function store(Request $request){
        $this->validate($request, [
            "exam_search" => "required|exists:exam_searches,id",
            "exam_type" => "required|exists:exam_types,id",
            "total_mark" => "required|numeric",
            "exam_hour" => "required|numeric",
            "hour_minute" => "required|numeric",
            "total_fee" => "required|numeric",
            "data*shift" => "required|exists:shifts,id",
            "data*group" => "required|exists:groups,id",
            "data*exam_shift" => "required|exists:exam_shifts,id",
            "subjects*subject_id" => "required|exists:subjects,id",
            "subjects*exam_date" => "required|date",
        ]);

        //Validation
        $check = ExamCreate::where('search_id', $request->exam_search)
                            ->where('type_id', $request->exam_type)
                            ->where('deleted_by',null)
                            ->latest()->get()->count();
        if($check>1){
            $this->message('error', 'Exam Already Created!');
            return redirect()->back()->withInput();
        }

        $exam_create = new ExamCreate;
        $exam_create->search_id = $request->exam_search;
        $exam_create->type_id = $request->exam_type;
        $exam_create->total_mark = $request->total_mark;
        $exam_create->duration = $request->exam_hour;
        $exam_create->hour_minute = $request->hour_minute;
        $exam_create->total_fee = $request->total_fee;
        $exam_create->created_by = Auth::user()->id;
        $exam_create->created_at = Carbon::now();
        $exam_create->save();

        foreach($request->data as $key => $data){
            $exam_schedules = new ExamSchedule;
            $exam_schedules->create_id = $exam_create->id;
            $exam_schedules->shift_id = $data['shift'];
            $exam_schedules->group_id = $data['group'];
            $exam_schedules->exam_shift_id = $data['exam_shift'];
            $exam_schedules->created_by = Auth::user()->id;
            $exam_schedules->created_at = Carbon::now();
            $exam_schedules->save();
        }

        foreach($request->subjects as $subject){
            $exam_subjects = new ExamSubject;
            $exam_subjects->create_id = $exam_create->id;
            $exam_subjects->subject_id = $subject['subject_id'];
            $exam_subjects->exam_date = new Carbon($subject['exam_date']);
            $exam_subjects->created_by = Auth::user()->id;
            $exam_subjects->created_at = Carbon::now();
            $exam_subjects->save();
        }


        $this->message('success', 'Exam Created Successfullly');
        return redirect()->route('em.create.show', $exam_create->search_id);
    }

    public function view($id){
        $exam_create = ExamCreate::findOrFail($id);
        $shifts = Shift::where('deleted_by',null)->latest()->get();
        $groups = Group::where('deleted_by',null)->latest()->get();

        return view('pages.exam-management.create-exam.view', ['groups' => $groups, 'shifts' => $shifts, 'exam_create' => $exam_create]);
    }

    public function get_routine(Request $request){
        if($request->ajax()) {
            $exam_create = ExamCreate::findOrFail($request->create_id);

            $data['exam_schedules'] = ExamSchedule::with(['group', 'shift', 'exam_shift'])->where('create_id', $exam_create->id)
                                                    ->where('shift_id', $request->shift_id)
                                                    ->where('group_id', $request->group_id)
                                                    ->where('deleted_by', null)
                                                    ->latest()->first();

            $data['exam_subjects'] = ExamSubject::with(['subject'])->where('create_id', $exam_create->id)
                                                ->where('deleted_by', null)
                                                ->latest()->get();
        }
        return response()->json($data);
    }

    public function update($id){
        $exam_create = ExamCreate::with(['search', 'type', 'schedules'])->findOrFail($id);
        $exam_search = ExamSearch::with(['session', 'department', 'semester', 'created_user', 'updated_user'])->findOrFail($exam_create->search_id);
        $exam_types = ExamType::where('deleted_by',null)->latest()->get();
        $exam_shifts = ExamShift::where('deleted_by',null)->latest()->get();
        $shifts = Shift::where('deleted_by',null)->latest()->get();
        $groups = Group::where('deleted_by',null)->latest()->get();
        $subjects = SubjectAssign::with(['subject'])
                                   ->where('session_id', $exam_search->session->id)
                                   ->where('department_id', $exam_search->department->id)
                                   ->where('deleted_by',null)
                                   ->latest()->get();

        return view('pages.exam-management.create-exam.update', ['subjects' => $subjects, 'exam_search' => $exam_search, 'groups' => $groups, 'shifts' => $shifts, 'exam_create' => $exam_create, 'exam_types' => $exam_types, 'exam_shifts' => $exam_shifts]);
    }

    public function update_store(Request $request){
        // dd($request->all());
        $this->validate($request, [
            "exam_search" => "required|exists:exam_searches,id",
            "exam_create" => "required|exists:exam_creates,id",
            "exam_type" => "required|exists:exam_types,id",
            "total_mark" => "required|numeric",
            "exam_hour" => "required|numeric",
            "hour_minute" => "required|numeric",
            "total_fee" => "required|numeric",
            "data*shift" => "required|exists:shifts,id",
            "data*group" => "required|exists:groups,id",
            "data*exam_shift" => "required|exists:exam_shifts,id",
            "subjects*subject_id" => "required|exists:subjects,id",
            "subjects*exam_date" => "required|date",
        ]);

        //Validation
        $check = ExamCreate::where('search_id', $request->exam_search)
                            ->where('type_id', $request->exam_type)
                            ->where('deleted_by',null)
                            ->latest()->get()->first();
        if($check->count() > 1 && $check->id != $request->exam_create ){
            $this->message('error', 'Exam Already Created!');
            return redirect()->back()->withInput();
        }

        $exam_create = ExamCreate::findOrFail($request->exam_create);
        $exam_create->search_id = $request->exam_search;
        $exam_create->type_id = $request->exam_type;
        $exam_create->total_mark = $request->total_mark;
        $exam_create->duration = $request->exam_hour;
        $exam_create->hour_minute = $request->hour_minute;
        $exam_create->total_fee = $request->total_fee;
        $exam_create->updated_by = Auth::user()->id;
        $exam_create->updated_at = Carbon::now();
        $exam_create->save();

        ExamSchedule::where('create_id', $exam_create->id)->delete();
        if(!empty($request->data)){
            foreach($request->data as $key => $data){
                $exam_schedules = new ExamSchedule;
                $exam_schedules->create_id = $exam_create->id;
                $exam_schedules->shift_id = $data['shift'];
                $exam_schedules->group_id = $data['group'];
                $exam_schedules->exam_shift_id = $data['exam_shift'];
                $exam_schedules->created_by = Auth::user()->id;
                $exam_schedules->created_at = Carbon::now();
                $exam_schedules->save();
            }
        }

        ExamSubject::where('create_id', $exam_create->id)->delete();
        if(!empty($request->subjects) && isset($subject['subject_id']) && isset($subject['exam_date'])){
            foreach($request->subjects as $subject){
                $exam_subjects = new ExamSubject;
                $exam_subjects->create_id = $exam_create->id;
                $exam_subjects->subject_id = $subject['subject_id'];
                $exam_subjects->exam_date = new Carbon($subject['exam_date']);
                $exam_subjects->created_by = Auth::user()->id;
                $exam_subjects->created_at = Carbon::now();
                $exam_subjects->save();
            }
        }

        $this->message('success', 'Exam Updated Successfullly');
        return redirect()->route('em.create.show', $exam_create->search_id);

    }

    public function delete($id){
        if($this->exam_check_availablity()){
            $exam_create = ExamCreate::findOrFail($id);
            $exam_create->delete();
            $this->message('success', 'Exam Deleted Successfully');
            return redirect()->route('em.create.show', $exam_create->search_id);
        }else{
            $this->message('error', 'Exam Can\'t be Deleted');
            return redirect()->route('em.create.show', $exam_create->search_id);
        }
    }

    public function exam_check_availablity(){
        return true;
    }
}
