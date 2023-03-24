<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Models\ExamType;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ExamTypeController extends Controller
{
    //


    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request){

        if ($request->ajax()) {
            $exam_types = ExamType::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($exam_types)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';

                            $btn .= '<a href="'.route("examtypes.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';


                            $btn .= '<a href="'.route("examtypes.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';

                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $exam_types = ExamType::where('deleted_at', null)->latest()->take(10)->get();
        return view('pages.setup.examtypes.index', ['exam_types' => $exam_types]);
    }

    public function create(){
        return view('pages.setup.examtypes.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:exam_types,name,NULL,id,deleted_at,NULL|string|max:255',
        ]);

        $insert = new ExamType;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Exam Type Created Successfullly');
        return redirect()->route('examtypes.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = ExamType::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id){
        $exam_type = ExamType::findOrFail($id);
        return view('pages.setup.examtypes.edit',['exam_type' => $exam_type]);
    }

    public function update(Request $request){
        $this->validate($request, [
            'id' => 'required|exists:exam_types,id',
            'name' => 'required|unique:exam_types,name,'.$request->id.',id,deleted_at,NULL|string|max:255',
        ]);

        $update = ExamType::findOrFail($request->id);
        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Exam Type Updated Successfully');
        return redirect()->route('examtypes.index');
    }

    public function destroy($id){
        if($id != null){
            $delete = ExamType::findOrFail($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = auth()->user()->id;
            $delete->save();
            $this->message('success', 'Exam Type '.$delete->name.' Deleted Successfully');
            return redirect()->route('examtypes.index');
        }

    }
}
