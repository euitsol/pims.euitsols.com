<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Credit;
use Illuminate\Support\Facades\Response;

class SubjectController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(){
        $this->check_access('view subject');
        $subjects = Subject::with(['created_user', 'updated_user', 'deleted_user', 'credit', 'department'])->where('deleted_at', null)->latest()->get();
        return view('pages.setup.subject.index', [ 'subjects' => $subjects ]);
    }

    public function create(){
        $this->check_access('add subject');
        $departments = Department::where('deleted_at', null)->latest()->get();
        $credits = Credit::where('deleted_at', null)->latest()->get();
        return view('pages.setup.subject.create', ['departments' => $departments, 'credits' => $credits ]);
    }

    public function store(Request $request){
        $this->check_access('add subject');
        $this->validate($request, [
            'name' => 'required|unique:subjects,name|string|max:255',
            'code' => 'required|unique:subjects,code|string|max:255',
            'credit_number' => 'required|exists:credits,id',
            'department_name' => 'required|exists:departments,id',
        ]);

        $subject = new Subject;
        $subject->name = $request->name;
        $subject->code = $request->code;
        $subject->credit_id = $request->credit_number;
        $subject->department_id = $request->department_name;
        $subject->created_by = auth()->user()->id;
        $subject->created_at = Carbon::now()->toDateTimeString();
        $subject->save();

        $this->message('success', 'Subject Created Successfullly');
        return redirect()->route('subject.index');
    }

    public function show($id=null){
        if($id!=null){
            $subject = Subject::with(['created_user', 'updated_user', 'deleted_user', 'credit', 'department'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($subject, 200);
        }
    }

    public function edit($id=null){
        $this->check_access('edit subject');
        if($id!=null){
            $departments = Department::where('deleted_at', null)->latest()->get();
            $credits = Credit::where('deleted_at', null)->latest()->get();
            $subject = Subject::findOrFail($id);
            return view('pages.setup.subject.edit',['departments' => $departments, 'credits' => $credits, 'subject' => $subject]);
        }
    }

    public function update(Request $request){
        $this->check_access('edit subject');
        $this->validate($request, [
            'id' => 'required|exists:subjects,id',
            'credit_number' => 'required|exists:credits,id',
            'department_name' => 'required|exists:departments,id',
        ]);
        $subject = Subject::findOrFail($request->id);

        if($subject->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:subjects,name|string|max:255']);
        }
        if($subject->code != $request->code){
            $this->validate($request, ['code' => 'required|unique:subjects,code|string|max:255']);
        }

        $subject->name = $request->name;
        $subject->code = $request->code;
        $subject->credit_id = $request->credit_number;
        $subject->department_id = $request->department_name;
        $subject->updated_by = auth()->user()->id;
        $subject->updated_at = Carbon::now()->toDateTimeString();
        $subject->save();

        $this->message('success', 'Subject '.$subject->name.' updated successfully');
        return redirect()->route('subject.index');
    }

    public function destroy($id=null){
        $this->check_access('delete subject');
        if($id != null){
            $subject = Subject::findOrFail($id);
            $subject->deleted_at = Carbon::now()->toDateTimeString();
            $subject->deleted_by = auth()->user()->id;
            $subject->save();

            $this->message('success', 'Subject '.$subject->name.' deleted successfully');
            return redirect()->route('subject.index');
        }
    }

}