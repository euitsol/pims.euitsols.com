<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\departmentModel;

class departmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $n['page_name'] = 'Department';
        $n['department_db'] = departmentModel::all();
        return view('pages.deparment.index',$n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // echo "echo";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // echo "store";
        $insert = new departmentModel;
        $insert->department_name =$request->name;
        $insert->short_name =$request->short_name;
        $insert->save();

        // dd($request->name) ;
        return Qs::jsonStoreOk();
        // return redirect()->route('departments.index')->with('insert');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // echo "nobir";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data_update = departmentModel::find($id);

        return view("pages.support_team.deparment.edit",compact("data_update"));
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
      $update = departmentModel::find($id);
      $update->department_name= $request->name;
      $update->short_name = $request->short_name;
      $update->save();
      return Qs::jsonUpdateOk();
    //   return redirect()->route("departments.index")->with("updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        departmentModel::find($id)->delete();
        return back()->with('flash_success', __('msg.del_ok'));
    }
}
