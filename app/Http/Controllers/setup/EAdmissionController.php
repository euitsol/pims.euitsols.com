<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eadmission;
use Illuminate\Support\Facades\Response;
use DataTables;
use Illuminate\Support\Facades\Auth;

class EAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->check_access('view exam-name');
        if ($request->ajax()) {
            $eadmissions = eadmission::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($eadmissions)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit exam-name') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("exam-name-admission.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete exam-name') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("exam-name-admission.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = eadmission::where('deleted_at', null)->latest()->get();
        return view('pages.setup.EAdmission.eadmission',$n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->check_access('add exam-name');
        return view('pages.setup.EAdmission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->check_access('add exam-name');
        $this->validate($request, [
            'name' => 'required|unique:eadmissions,name|string|max:255',
            'short_name' => 'required|unique:eadmissions,short_name|string|max:255',
        ]);

        $insert = new eadmission;
        $insert->name = $request->name;
        $insert->short_name = $request->short_name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Exam Created Successfullly');
        return redirect()->route('exam-name-admission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=null)
    {
        if($id!=null){
            $eadmission = eadmission::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($eadmission, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->check_access('edit exam-name');
        $n['db_data'] = eadmission::findOrFail($id);
        return view('pages.setup.EAdmission.edit',$n);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->check_access('edit exam-name');
        $this->validate($request, [
            'id' => 'required|exists:eadmissions,id',
        ]);
        //dd('this');

        $update = eadmission::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => "required|unique:eadmissions,name,$request->id,id,deleted_at,NULL|string|max:255"]);
        }
        if($update->short_name != $request->short_name){
            $this->validate($request, ['short_name' => 'required|unique:eadmissions,short_name|string|max:255']);
        }

        $update->name = $request->name;
        $update->short_name = $request->short_name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Exam Updated Successfully');
        return redirect()->route('exam-name-admission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->check_access('delete exam-name');
        if($id != null){
            $user = eadmission::findOrFail($id);
            $user->deleted_at = Carbon::now()->toDateTimeString();
            $user->deleted_by = auth()->user()->id;
            $user->save();
            $this->message('success', 'User '.$user->name.' deleted successfully');
            return redirect()->route('users.index');
        }

    }



}