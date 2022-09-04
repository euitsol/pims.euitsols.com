<?php

namespace App\Http\Controllers\SupportTeam;
use App\Models\n_subjectModel;
use App\Models\departmentModel;
use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Nsubjectcontroller extends Controller
{

    // public function nobir(){
    //     echo "insert";
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject_db = n_subjectModel::all();
        $department_db = departmentModel::all();
        return view('pages.support_team.Nsubject.index',compact('subject_db',"department_db"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $insert = new n_subjectModel; 

        $insert->departments_id =$request->departments_id;
        $insert->subject_name =$request->name;
        $insert->short_name =$request->short_name;
        
        $insert->save();

        return Qs::jsonStoreOk();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data_update = n_subjectModel::find($id);
        $department_db = departmentModel::all();

        return view("pages.support_team.Nsubject.edit",compact("data_update","department_db"));
        // return view("pages.support_team.Nsubject.edit",compact("department_db"));
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
        //
      $update = n_subjectModel::find($id);
    //   $update = departmentModel::find($id);
      $update->departments_id = $request->departments_id;
      $update->subject_name = $request->name;
      $update->short_name = $request->short_name;
      $update->save();
      return Qs::jsonUpdateOk();
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
        n_subjectModel::find($id)->delete();
        return back()->with('flash_success', __('msg.del_ok'));
    }
}
