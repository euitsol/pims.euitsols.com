<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eadmission;
use Illuminate\Support\Facades\Response;

class EAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $this->validate($request, [
            'name' => 'required|unique:eadmissions,name|string|max:255',
            'short_name' => 'required|unique:eadmissions,short_name|string|max:255',
        ]);

        // $exam = eadmission::create([
        //     'name' => $request->name,
        //     'short_name' => $request->short_name,
        // ]);
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
        $this->validate($request, [
            'id' => 'required|exists:eadmissions,id',
        ]);

        $update = eadmission::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:eadmissions,name|string|max:255']);
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
