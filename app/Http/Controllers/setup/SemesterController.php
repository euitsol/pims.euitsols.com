<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Semester;
use Illuminate\Support\Facades\Response;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SemesterController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $this->check_access('view semester');
        if ($request->ajax()) {
            $semesters = Semester::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($semesters)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit semester') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("semester.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete semester') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("semester.delete", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $semesters = Semester::where('deleted_at', null)->latest()->get();
        return view('pages.setup.semester.index', [ 'semesters' => $semesters ]);
    }

    public function add(){
        $this->check_access('add semseter');
        return view('pages.setup.semester.create');
    }

    public function store(Request $request){
        $this->check_access('add semseter');
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
        $this->check_access('edit semseter');
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
