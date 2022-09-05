<?php

namespace App\Http\Controllers;
use App\Helpers\Qs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class departmentController extends Controller
{

    public function __construct() {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $n['data'] = Department::all();
        $n['page_name'] = 'Department';
        return view('page.deparment.show',$n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $n['page_name'] = 'Department';
        return view('page.deparment.create',$n);
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
        $insert = new Department;
        $insert->department_name =$request->name;
        $insert->short_name =$request->short_name;
        $insert->save();

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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data_update = Department::find($id);

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
      $update = Department::find($id);
      $update->department_name= $request->name;
      $update->short_name = $request->short_name;
      $update->save();
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
        Department::find($id)->delete();
        return back()->with('flash_success', __('msg.del_ok'));
    }
}
