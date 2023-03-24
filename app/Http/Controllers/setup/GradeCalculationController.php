<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Grade;
use App\Models\Lettergrade;
use DataTables;
use Illuminate\Support\Facades\Auth;

class GradeCalculationController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->check_access('view grade-calculation');
        if ($request->ajax()) {
            $grades = Grade::with(['created_user', 'letterGrade'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($grades)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->editColumn('grade_point', function($data){ $format_grade_point = number_format((float)$data->grade_point, 2, '.', ''); return $format_grade_point; })
                    ->editColumn('marks', function($data){ $format_marks =  $data->mark_start.' - '. $data->mark_end; return $format_marks; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('letterGrade', function ($data) {
                        return $data->letterGrade->name;
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit grade-calculation') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("grade.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete grade-calculation') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("grade.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Grade::where('deleted_at', null)->latest()->get();
        return view('pages.setup.grade.index',$n);
    }

    public function create()
    {
        $this->check_access('add grade-calculation');
        $letter_grades = Lettergrade::where('deleted_at',null)->latest()->get();
        return view('pages.setup.grade.create',compact('letter_grades'));
    }

    public function store(Request $request)
    {
        $this->check_access('add grade-calculation');
        $this->validate($request, [
            'mark_start' => 'required|numeric',
            'mark_end' => 'required|numeric',
            'grade_point' => 'required|numeric',
        ]);

        $insert = new Grade;
        $insert->lettergrades_id = $request->grade;
        $insert->mark_start = $request->mark_start;
        $insert->mark_end = $request->mark_end;
        $insert->grade_point = $request->grade_point;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Grade Calculation Created Successfullly');
        return redirect()->route('grade.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $grade = grade::with(['created_user', 'updated_user', 'deleted_user', 'letterGrade',])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($grade, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit grade-calculation');
        $n['grade'] = Lettergrade::where('deleted_at', null)->latest()->get();
        $n['db_data'] = grade::findOrFail($id);
        return view('pages.setup.grade.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit grade-calculation');
        $this->validate($request, [
            'id' => 'required|exists:grades,id',
        ]);

        $update = Grade::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:grades,name|string|max:255']);
        }
        $update = grade::findOrFail($request->id);
        $update->lettergrades_id = $request->grade;
        $update->mark_start = $request->mark_start;
        $update->mark_end = $request->mark_end;
        $update->grade_point = $request->grade_point;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Grade Calculation Updated Successfully');
        return redirect()->route('grade.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete grade-calculation');
        if($id != null){
            $grade = Grade::findOrFail($id);
            $grade->deleted_at = Carbon::now()->toDateTimeString();
            $grade->deleted_by = auth()->user()->id;
            $grade->save();
            $this->message('success', 'Grade '.$grade->name.' deleted successfully');
            return redirect()->route('grade.index');
        }

    }
}
