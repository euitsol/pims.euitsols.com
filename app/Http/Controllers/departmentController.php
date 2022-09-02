<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\departmentModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $n['page_name'] = 'Department';
        $n['department_db'] = departmentModel::where('deleted_at', null)->get();

        return view('pages.deparment.index',$n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $n['page_name'] = 'Department';
        return view('pages.deparment.create',$n);
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
            'name' => 'required|unique:departments,department_name|string|max:255',
            'short_name' => 'required|unique:departments,short_name|string|max:255',
        ]);

        $insert = new departmentModel;
        $insert->department_name =$request->name;
        $insert->short_name =$request->short_name;
        $insert->created_at =Carbon::now()->toDateTimeString();
        $insert->created_by =auth()->user()->id;
        $insert->save();

        // dd($request->name) ;
        return redirect()->route('departments.index')->with('success',' Department successfully created');
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
