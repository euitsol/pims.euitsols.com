<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Grade;
use App\Models\Lettergrade;

class GradeCalculationController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $n['db_data'] = Grade::where('deleted_at', null)->latest()->get();
        return view('pages.setup.grade.index',$n);
    }

    public function create()
    {
        $letter_grades = Lettergrade::where('deleted_at',null)->latest()->get();
        return view('pages.setup.grade.create',compact('letter_grades'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'mark_start' => 'required|numeric',
            'mark_end' => 'required|numeric',
            'grade_point' => 'required|numeric',
        ]);

        $insert = new grade;
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
        $n['grade'] = Lettergrade::where('deleted_at', null)->latest()->get();
        $n['db_data'] = grade::findOrFail($id);
        return view('pages.setup.grade.edit',$n);


    }

    public function update(Request $request)
    {

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
