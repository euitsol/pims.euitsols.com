<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Group;

class GroupController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $this->check_access('view group');
        $n['db_data'] = Group::where('deleted_at', null)->latest()->get();
        return view('pages.setup.group.index',$n);
    }

    public function create()
    {
        $this->check_access('add group');
        return view('pages.setup.group.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:groups,name|string|max:255',
        ]);

        $insert = new group;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Group Created Successfullly');
        return redirect()->route('group.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Group::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit group');
        $n['db_data'] = Group::findOrFail($id);
        return view('pages.setup.group.edit',$n);


    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:groups,id',
        ]);

        $update = Group::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:groups,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Group Updated Successfully');
        return redirect()->route('group.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete group');
        if($id != null){
            $group = Group::findOrFail($id);
            $group->deleted_at = Carbon::now()->toDateTimeString();
            $group->deleted_by = auth()->user()->id;
            $group->save();
            $this->message('success', 'Group '.$group->name.' deleted successfully');
            return redirect()->route('group.index');
        }

    }
}
