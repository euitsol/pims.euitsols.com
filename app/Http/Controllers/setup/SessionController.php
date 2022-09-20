<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Session;
use Illuminate\Support\Facades\Response;

class SessionController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $this->check_access('view session');
        $sessions = Session::where('deleted_at', null)->latest()->get();
        return view('pages.setup.session.index', [ 'sessions' => $sessions ]);
    }

    public function add(){
        $this->check_access('add session');
        return view('pages.setup.session.create');
    }

    public function store(Request $request){
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
