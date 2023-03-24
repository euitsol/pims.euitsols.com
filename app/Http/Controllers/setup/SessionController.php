<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Session;
use Illuminate\Support\Facades\Response;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $this->check_access('view session');
        if ($request->ajax()) {
            $sessions = Session::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($sessions)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->editColumn('session_year', function($data){ $format_session_year =  $data->start.' - '.$data->end; return $format_session_year; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit session') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("session.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete semester') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("session.delete", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $sessions = Session::where('deleted_at', null)->latest()->get();
        return view('pages.setup.session.index', [ 'sessions' => $sessions ]);
    }

    public function add(){
        $this->check_access('add session');
        return view('pages.setup.session.create');
    }

    public function store(Request $request){
        $this->check_access('add session');
        $this->validate($request, [
            'start_year' => 'required|date_format:Y',
            'end_year' => 'required|date_format:Y',
            // 'name' => 'required|unique:sessions,name|string|max:255',
            'details' => 'nullable||max:60000',
        ]);

        $session = new Session;
        $session->start = $request->start_year;
        $session->end = $request->end_year;
        // $session->name = $request->name;
        $session->details = $request->details;
        $session->created_by = auth()->user()->id;
        $session->created_at = Carbon::now()->toDateTimeString();
        $session->save();

        $this->message('success', 'Session Created Successfullly');
        return redirect()->route('session.index');
    }

    public function details($id=null){
        if($id!=null){
            $session = Session::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($session, 200);
        }
    }

    public function edit($id=null){
        $this->check_access('edit session');
        if($id!=null){
            $session = Session::findOrFail($id);
            return view('pages.setup.session.edit',['session' => $session]);
        }
    }

    public function edit_store(Request $request){
        $this->check_access('edit session');
        $this->validate($request, [
            'id' => 'required|exists:sessions,id',
            'details' => 'nullable|max:60000',
        ]);
        $session = Session::findOrFail($request->id);
        if($session->start != $request->start_year){
            $this->validate($request, ['start_year' => 'required|unique:sessions,start|date_format:Y']);
        }
        if($session->end != $request->end_year){
            $this->validate($request, ['end_year' => 'required|unique:sessions,end|date_format:Y']);
        }

        $session->start = $request->start_year;
        $session->end = $request->end_year;
        // $session->name = $request->name;
        $session->details = $request->details;
        $session->updated_at = Carbon::now()->toDateTimeString();
        $session->updated_by = auth()->user()->id;
        $session->save();

        $this->message('success', 'Session '.$session->start.' - '.$session->end.' updated successfully');
        return redirect()->route('session.index');
    }

    public function delete($id=null){
        $this->check_access('delete session');
        if($id != null){
            $session = Session::findOrFail($id);
            $session->deleted_at = Carbon::now()->toDateTimeString();
            $session->deleted_by = auth()->user()->id;
            $session->save();
            $this->message('success', 'Session '.$session->start.' - '.$session->end.' deleted successfully');
            return redirect()->route('session.index');
        }
    }
}
