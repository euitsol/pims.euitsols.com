<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Bloodgroup;

class BloodGroupController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $this->check_access('view blood-group');
        $n['db_data'] = Bloodgroup::where('deleted_at', null)->latest()->get();
        return view('pages.setup.bloodgroup.index',$n);
    }

    public function create()
    {
        $this->check_access('add blood-group');
        return view('pages.setup.bloodgroup.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add blood-group');
        $this->validate($request, [
            'name' => 'required|unique:bloodgroups,name|string|max:255',
        ]);

        $insert = new bloodgroup;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Blood Group Created Successfullly');
        return redirect()->route('bloodgroup.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Bloodgroup::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit blood-group');
        $n['db_data'] = Bloodgroup::findOrFail($id);
        return view('pages.setup.bloodgroup.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit blood-group');
        $this->validate($request, [
            'id' => 'required|exists:bloodgroups,id',
        ]);

        $update = Bloodgroup::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:bloodgroups,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Blood Group Updated Successfully');
        return redirect()->route('bloodgroup.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete blood-group');
        if($id != null){
            $bloodgroup = Bloodgroup::findOrFail($id);
            $bloodgroup->deleted_at = Carbon::now()->toDateTimeString();
            $bloodgroup->deleted_by = auth()->user()->id;
            $bloodgroup->save();
            $this->message('success', 'Blood Group '.$bloodgroup->name.' deleted successfully');
            return redirect()->route('bloodgroup.index');
        }

    }
}

