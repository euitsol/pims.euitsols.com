<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Shift;


class ShiftController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $n['db_data'] = Shift::where('deleted_at', null)->latest()->get();
        return view('pages.setup.shift.index',$n);
    }

    public function create()
    {
        return view('pages.setup.shift.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:shifts,name|string|max:255',
        ]);

        $insert = new shift;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Shift Created Successfullly');
        return redirect()->route('shift.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $shift = Shift::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($shift, 200);
        }
    }

    public function edit($id)
    {
        $n['db_data'] = Shift::findOrFail($id);
        return view('pages.setup.shift.edit',$n);


    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:shifts,id',
        ]);

        $update = Shift::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:shifts,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Shift Updated Successfully');
        return redirect()->route('shift.index');
    }

    public function destroy($id)
    {
        if($id != null){
            $shift = Shift::findOrFail($id);
            $shift->deleted_at = Carbon::now()->toDateTimeString();
            $shift->deleted_by = auth()->user()->id;
            $shift->save();
            $this->message('success', $shift->name.' deleted successfully');
            return redirect()->route('shift.index');
        }

    }
}
