<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Semester;
use Illuminate\Support\Facades\Response;

class SemesterController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $this->check_access('view semester');
        $semesters = Semester::where('deleted_at', null)->latest()->get();
        return view('pages.setup.semester.index', [ 'semesters' => $semesters ]);
    }

    public function add(){
        $this->check_access('add semseter');
        return view('pages.setup.semester.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:semesters,name|string|max:255',
            'details' => 'nullable||max:60000',
        ]);

        $semester = new Semester;
        $semester->name = $request->name;
        $semester->details = $request->details;
        $semester->created_by = auth()->user()->id;
        $semester->created_at = Carbon::now()->toDateTimeString();
        $semester->save();

        $this->message('success', 'Semester Created Successfullly');
        return redirect()->route('semester.index');
    }

    public function details($id=null){
        if($id!=null){
            $semester = Semester::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($semester, 200);
        }
    }

    public function edit($id=null){
        $this->check_access('edit semseter');
        if($id!=null){
            $semester = Semester::findOrFail($id);
            return view('pages.setup.semester.edit',['semester' => $semester]);
        }
    }

    public function edit_store(Request $request){
        $this->validate($request, [
            'id' => 'required|exists:semesters,id',
            'details' => 'nullable||max:60000',
        ]);
        $semester = Semester::findOrFail($request->id);
        if($semester->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:semesters,name|string|max:255']);
        }

        $semester->name = $request->name;
        $semester->details = $request->details;
        $semester->updated_at = Carbon::now()->toDateTimeString();
        $semester->updated_by = auth()->user()->id;
        $semester->save();

        $this->message('success', 'Semester '.$semester->name.' updated successfully');
        return redirect()->route('semester.index');
    }

    public function delete($id=null){
        $this->check_access('delete semseter');
        if($id != null){
            $semester = Semester::findOrFail($id);
            $semester->deleted_at = Carbon::now()->toDateTimeString();
            $semester->deleted_by = auth()->user()->id;
            $semester->save();
            $this->message('success', 'Semester '.$semester->name.' deleted successfully');
            return redirect()->route('semester.index');
        }
    }


}
