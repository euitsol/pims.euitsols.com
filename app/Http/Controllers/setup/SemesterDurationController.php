<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Semester;
use App\Models\Session;
use App\Models\SemesterDuration;
use Illuminate\Support\Facades\Response;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SemesterDurationController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $this->check_access('view semester-duration');
        if ($request->ajax()) {
            $semesterduration = SemesterDuration::with(['created_user', 'session', 'semester'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($semesterduration)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->editColumn('duration', function($data){ $format_duration =  date('M-Y', strtotime($data->start)).' - '. date('M-Y', strtotime($data->end));return $format_duration; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('session', function ($data) {
                        return $data->session->start.' - '. $data->session->end;
                    })
                    ->addColumn('semester', function ($data) {
                        return $data->semester->name;
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit semester-duration') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("semesterDuration.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete semester-duration') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("semesterDuration.delete", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $semester_sessions = SemesterDuration::where('deleted_at', null)->orderBy('session_id')->latest()->get();
        return view('pages.setup.semester_duration.index', ['semester_sessions' => $semester_sessions]);
    }

    public function add(){
        $this->check_access('add semester-duration');
        $semesters = Semester::where('deleted_at', null)->latest()->get();
        $sessions = Session::where('deleted_at', null)->latest()->get();
        return view('pages.setup.semester_duration.create', ['semesters' => $semesters, 'sessions' => $sessions]);
    }

    public function store(Request $request){
        $this->check_access('add semester-duration');
        $this->validate($request, [
            'semester' => 'required|exists:semesters,id',
            'session' => 'required|exists:sessions,id',
            'start_month' => 'required',
            'end_month' => 'required',
        ]);

        if(SemesterDuration::where('semester_id', $request->semester)->where('session_id', $request->session)->where('deleted_at', null)->get()->count() > 0){
            return redirect()->back()->withInput()->withErrors(['semester' => 'This semester has already been taken for selected session']);
        }

        $start_month = Carbon::parse($request->start_month);
        $end_month = Carbon::parse($request->end_month);

        $check = SemesterDuration::where('session_id', $request->session)->where('deleted_at', null)->latest()->get();
        foreach( $check as $ck){
            if($ck->start <= $start_month && $start_month <= $ck->end){
                return redirect()->back()->withInput()->withErrors(['start_month' => 'Start month cannot be in between two previous month']);
            }
            if($ck->start <= $end_month && $end_month <= $ck->end){
                return redirect()->back()->withInput()->withErrors(['end_month' => 'End month cannot be in between two previous month']);
            }
        }

        $save = new SemesterDuration;
        $save->semester_id = $request->semester;
        $save->session_id = $request->session;
        $save->start = $start_month;
        $save->end = $end_month;
        $save->created_by = auth()->user()->id;
        $save->created_at = Carbon::now()->toDateTimeString();
        $save->save();

        $this->message('success', 'Session Duration Added Successfullly');
        return redirect()->route('semesterDuration.index');
    }

    public function details($id=null){
        if($id!=null){
            $session = SemesterDuration::with(['created_user', 'updated_user', 'deleted_user', 'semester', 'session'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($session, 200);
        }
    }

    public function edit($id=null){
        $this->check_access('edit semester-duration');
        if($id!=null){
            $semesters = Semester::where('deleted_at', null)->latest()->get();
            $sessions = Session::where('deleted_at', null)->latest()->get();
            $semester_session = SemesterDuration::findOrFail($id);
            return view('pages.setup.semester_duration.edit',['semesters' => $semesters, 'sessions' => $sessions, 'semester_session' => $semester_session]);
        }
    }

    public function edit_store(Request $request){
        $this->check_access('edit semester-duration');
        $this->validate($request, [
            'id' => 'required|exists:semester_durations,id',
            'semester' => 'required|exists:semesters,id',
            'session' => 'required|exists:sessions,id',
        ]);

        if(SemesterDuration::where('semester_id', $request->semester)->where('session_id', $request->session)->where('deleted_at', null)->get()->except($request->id)->count() > 0){
            return redirect()->back()->withInput()->withErrors(['semester' => 'This semester has already been taken for selected session']);
        }

        $start_month = Carbon::parse($request->start_month);
        $end_month = Carbon::parse($request->end_month);

        $semester_session = SemesterDuration::findOrFail($request->id);
        $check = SemesterDuration::where('session_id', $request->session)->where('deleted_at', null)->latest()->get()->except($semester_session->id);

        if($semester_session->start != $start_month){
            foreach( $check as $ck){
                if($ck->start <= $start_month && $start_month <= $ck->end){
                    return redirect()->back()->withInput()->withErrors(['start_month' => 'Start month cannot be in between two previous month']);
                }
            }
        }
        if($semester_session->end != $end_month){
            foreach( $check as $ck){
                if($ck->start <= $end_month && $end_month <= $ck->end){
                    return redirect()->back()->withInput()->withErrors(['end_month' => 'End month cannot be in between two previous month']);
                }
            }
        }

        $semester_session->semester_id = $request->semester;
        $semester_session->session_id = $request->session;
        $semester_session->start = $start_month;
        $semester_session->end = $end_month;
        $semester_session->updated_at = Carbon::now()->toDateTimeString();
        $semester_session->updated_by = auth()->user()->id;
        $semester_session->save();

        $this->message('success', 'Semester duration updated successfully');
        return redirect()->route('semesterDuration.index');
    }

    public function delete($id=null){
        $this->check_access('delete semester-duration');
        if($id != null){
            $semester_session = SemesterDuration::findOrFail($id);
            $semester_session->deleted_at = Carbon::now()->toDateTimeString();
            $semester_session->deleted_by = auth()->user()->id;
            $semester_session->save();
            $this->message('success', 'Session duration deleted successfully');
            return redirect()->route('session.index');
        }
    }

    public function get_duration($session_id){
        $durations = SemesterDuration::with(['semester', 'session'])->where('session_id', $session_id)->where('deleted_at', null)->latest()->get();
        return Response::json($durations, 200);
    }
}
