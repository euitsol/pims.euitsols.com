<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eadmission;

class EAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $n['db_data'] = eadmission::all();
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
            'name' => 'required|string|max:255',
            'short_name' => 'required|max:255',
        ]);

        // $exam = eadmission::create([
        //     'name' => $request->name,
        //     'short_name' => $request->short_name,
        // ]);
        $insert = new eadmission;
        $insert->name = $request->name;
        $insert->short_name = $request->short_name;
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
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $n['db_data'] = eadmission::find($id);
        return view('pages.setup.EAdmission.edit',$n);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'short_name' => 'required|max:255',
        ]);

        // $exam = eadmission::create([
        //     'name' => $request->name,
        //     'short_name' => $request->short_name,
        // ]);
        $update = eadmission::find($id);
        $update->name = $request->name;
        $update->short_name = $request->short_name;
        $update->save();

        $this->message('success', 'Exam Update Successfullly');
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
        //
        eadmission::find($id)->delete();
        $this->message('success', 'Exam Deleted Successfullly');
    }
}
