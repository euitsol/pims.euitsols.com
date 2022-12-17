<?php

namespace App\Http\Controllers;
use App\Models\Semester;
use App\Models\Shift;
use App\Models\Group;
use App\Models\Session;
use App\Models\Department;
use App\Models\ExamSearch;
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

        return view('pages.exam-management.create-exam.show', ['exam_search' => $exam_search, 'shifts' => $shifts, 'groups' => $groups]);
    }

    public function add($id){
        $exam_search = ExamSearch::with(['session', 'department', 'semester', 'created_user', 'updated_user'])->findOrFail($id);
        $shifts = Shift::where('deleted_by',null)->latest()->get();
        $groups = Group::where('deleted_by',null)->latest()->get();

        return view('pages.exam-management.create-exam.create', ['exam_search' => $exam_search, 'shifts' => $shifts, 'groups' => $groups]);
    }
}
