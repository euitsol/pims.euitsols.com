<?php

namespace App\Http\Controllers\setup;
use App\Helpers\Qs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

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

        $n['data'] = Department::where('deleted_by',null)->get(   );
        $n['page_name'] = 'Department';
        return view('pages.setup.deparment.show',$n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $n['page_name'] = 'Department';
        return view('pages.setup.deparment.create',$n);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:departments,department_name|string',
            'short_name' => 'required|unique:departments,short_name|string'
        ]);

        // echo "store";
        $insert = new Department;
        $insert->department_name =$request->name;
        $insert->short_name =$request->short_name;
        // 'created_by' => auth()->user()->id, 'created_at' => Carbon::now()->toDateTimeString()
        $insert->save();

        return redirect()->route('department.index')->with('Department Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id!=null){
            $group = Department::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
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
        $n['data_update'] = Department::find($id);
        $n['page_name'] = 'Department';
        return view("pages.setup.deparment.edit",$n);
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
      $this->message('success','Successfully updated');
      return redirect()->route("department.index");
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
            $depertment = Department::findOrFail($id);
            $depertment->deleted_at = Carbon::now()->toDateTimeString();
            $depertment->deleted_by = auth()->user()->id;
            $depertment->save();
            $this->message('success',$depertment->name.' deleted successfully');
            return redirect()->route('department.index');
        }
    }

    public function delete($id){
        echo 'ok';
        if($id != null){
            $depertment = Department::findOrFail($id);
            $depertment->deleted_at = Carbon::now()->toDateTimeString();
            $depertment->deleted_by = auth()->user()->id;
            $depertment->save();
            $this->message('success',$depertment->name.' deleted successfully');
            return redirect()->route('department.index');
        }
    }
}
