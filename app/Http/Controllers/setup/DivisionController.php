<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Division;

class DivisionController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $n['db_data'] = Division::where('deleted_at', null)->latest()->get();
        return view('pages.setup.division.index',$n);
    }

    public function create()
    {
        return view('pages.setup.division.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:divisions,name|string|max:255',
        ]);

        $insert = new division;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Division Created Successfullly');
        return redirect()->route('division.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $division = Division::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($division, 200);
        }
    }

    public function edit($id)
    {
        $n['db_data'] = Division::findOrFail($id);
        return view('pages.setup.division.edit',$n);


    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:divisions,id',
        ]);

        $update = Division::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:divisions,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Division Updated Successfully');
        return redirect()->route('division.index');
    }

    public function destroy($id)
    {
        if($id != null){
            $division = Division::findOrFail($id);
            $division->deleted_at = Carbon::now()->toDateTimeString();
            $division->deleted_by = auth()->user()->id;
            $division->save();
            $this->message('success', 'Division '.$division->name.' deleted successfully');
            return redirect()->route('division.index');
        }

    }
}
