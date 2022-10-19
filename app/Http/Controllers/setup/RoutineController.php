<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Session;
use App\Models\Department;
use App\Models\Group;
use App\Models\Shift;
use App\Models\Routine;
use App\Models\RoutineDates;

class RoutineController extends Controller
{
    //
    public function index(){
        $sessions = Session::where('deleted_at', null)->latest()->get();
        $semesters = Semester::where('deleted_at', null)->latest()->get();
        $departments = Department::where('deleted_by', null)->latest()->get();
        $groups = Group::where('deleted_by', null)->latest()->get();
        $shifts = Shift::where('deleted_by', null)->latest()->get();

        return view('pages.setup.routine.index', ['semesters' => $semesters, 'sessions' => $sessions, 'departments' => $departments, 'groups' => $groups, 'shifts' => $shifts]);
    }

    public function search(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'department' => 'required|exists:departments,id',
            'semester' => 'required|exists:semesters,id',
            'group' => 'required|exists:groups,id',
            'shift' => 'required|exists:shifts,id',
        ]);

        $routine = Routine::where('session_id', $request->session)->where('department_id', $request->department)->where('semester_id', $request->semester)->where('group_id', $request->group)->where('shift_id', $request->shift)->where('deleted_at', null)->latest()->first();
        if($routine == null){
            $routine = new Routine;
            $routine->session_id = $request->session;
            $routine->department_id = $request->department;
            $routine->semester_id = $request->semester;
            $routine->group_id = $request->group;
            $routine->shift_id = $request->shift;
            $routine->created_at = Carbon::now()->toDateTimeString();
            $routine->created_by = auth()->user()->id;
            $routine->save();
        }
        return view('pages.setup.routine.create', ['routine' => $routine]);

    }
    public function calendarEvents(Request $request){
        switch ($request->type) {
            case 'create':
                $event = RoutineDates::create([
                    'subject_id ' => $request->subject_id ,
                    'routine_id' => $request->routine_id,
                    'day' => $request->day,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

               return response()->json($event);
              break;

            case 'edit':
               $event = RoutineDates::find($request->id)->update([
                    'subject_id ' => $request->subject_id ,
                    'routine_id' => $request->routine_id,
                    'day' => $request->day,
                    'start' => $request->start,
                    'end' => $request->end,
               ]);

               return response()->json($event);
              break;

            case 'delete':
               $event = RoutineDates::find($request->id)->delete();

               return response()->json($event);
              break;

            default:

              break;
         }
    }
}
