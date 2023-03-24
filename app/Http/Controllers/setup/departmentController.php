<?php

namespace App\Http\Controllers\setup;

use App\Helpers\Qs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;

class departmentController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->check_access('view department');
        if ($request->ajax()) {
            $departments = Department::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($departments)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit department') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("department.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete department') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("department.delete", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['data'] = Department::where('deleted_by', null)->get();
        $n['page_name'] = 'Department';
        return view('pages.setup.deparment.show', $n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->check_access('add department');
        $n['page_name'] = 'Department';
        return view('pages.setup.deparment.create', $n);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->check_access('add department');
        $this->validate($request, [
            'name' => 'required|unique:departments,department_name|string',
            'short_name' => 'required|unique:departments,short_name|string'
        ]);

        // echo "store";
        $insert = new Department;
        $insert->department_name = $request->name;
        $insert->short_name = $request->short_name;
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
        if ($id != null) {
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
        $this->check_access('edit department');
        $n['data_update'] = Department::find($id);
        $n['page_name'] = 'Department';
        return view("pages.setup.deparment.edit", $n);
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
        $this->check_access('edit department');
        $update = Department::find($id);
        $update->department_name = $request->name;
        $update->short_name = $request->short_name;
        $update->save();
        $this->message('success', 'Successfully updated');
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
        $this->check_access('delete department');
        if ($id != null) {
            $depertment = Department::findOrFail($id);
            $depertment->deleted_at = Carbon::now()->toDateTimeString();
            $depertment->deleted_by = auth()->user()->id;
            $depertment->save();
            $this->message('success', $depertment->name . ' deleted successfully');
            return redirect()->route('department.index');
        }
    }

    public function delete($id)
    {
        $this->check_access('delete department');
        if ($id != null) {
            $depertment = Department::findOrFail($id);
            $depertment->deleted_at = Carbon::now()->toDateTimeString();
            $depertment->deleted_by = auth()->user()->id;
            $depertment->save();
            $this->message('success', $depertment->name . ' deleted successfully');
            return redirect()->route('department.index');
        }
    }
}
