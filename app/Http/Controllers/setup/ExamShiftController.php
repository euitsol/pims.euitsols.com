<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Models\ExamShift;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ExamShiftController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request){

        if ($request->ajax()) {
            $exam_shifts = ExamShift::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($exam_shifts)
                    ->addIndexColumn()
                    ->editColumn('start', function($data){ $formatedtime = date('h:i A', strtotime($data->start)); return $formatedtime; })
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';

                            $btn .= '<a href="'.route("examshifts.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';


                            $btn .= '<a href="'.route("examshifts.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';

                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $exam_shifts = ExamShift::where('deleted_at', null)->latest()->take(10)->get();
        return view('pages.setup.examshifts.index', ['exam_shifts' => $exam_shifts]);
    }

    public function create(){
        return view('pages.setup.examshifts.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:exam_shifts,name,NULL,id,deleted_at,NULL|string|max:255',
            'start' =>'required|unique:exam_shifts,start,NULL,id,deleted_at,NULL|date_format:H:i',
        ], [], [
            'start' => 'start time',
        ]);

        $insert = new ExamShift;
        $insert->name = $request->name;
        $insert->start = $request->start;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Exam Shift Created Successfullly');
        return redirect()->route('examshifts.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = ExamShift::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id){
        $exam_shift = ExamShift::findOrFail($id);
        return view('pages.setup.examshifts.edit',['exam_shift' => $exam_shift]);
    }

    public function update(Request $request){
        $this->validate($request, [
            'id' => 'required|exists:exam_shifts,id',
            'name' => 'required|unique:exam_shifts,name,'.$request->id.',id,deleted_at,NULL|string|max:255',
            'start' =>'required|unique:exam_shifts,start,'.$request->id.',id,deleted_at,NULL|date_format:H:i',
        ]);

        $update = ExamShift::findOrFail($request->id);
        $update->name = $request->name;
        $update->start = $request->start;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Exam Shift Updated Successfully');
        return redirect()->route('examshifts.index');
    }

    public function destroy($id){
        if($id != null){
            $delete = ExamShift::findOrFail($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = auth()->user()->id;
            $delete->save();
            $this->message('success', 'Exam Shift '.$delete->name.' Deleted Successfully');
            return redirect()->route('examshifts.index');
        }

    }
}
