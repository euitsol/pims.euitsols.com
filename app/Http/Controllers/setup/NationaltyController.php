<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Nationality;

class NationaltyController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $this->check_access('view nationality');
        $n['db_data'] = Nationality::where('deleted_at', null)->latest()->get();
        return view('pages.setup.nationality.index',$n);
    }

    public function create()
    {
        $this->check_access('add nationality');
        return view('pages.setup.nationality.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add nationality');
        $this->validate($request, [
            'name' => 'required|unique:nationalities,name|string|max:255',
        ]);

        $insert = new nationality;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Nationality Created Successfullly');
        return redirect()->route('nationality.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Nationality::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit nationality');
        $n['db_data'] = Nationality::findOrFail($id);
        return view('pages.setup.nationality.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit nationality');
        $this->validate($request, [
            'id' => 'required|exists:nationalities,id',
        ]);

        $update = Nationality::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:nationalities,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Nationality Updated Successfully');
        return redirect()->route('nationality.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete nationality');
        if($id != null){
            $nationality = Nationality::findOrFail($id);
            $nationality->deleted_at = Carbon::now()->toDateTimeString();
            $nationality->deleted_by = auth()->user()->id;
            $nationality->save();
            $this->message('success', 'Group '.$nationality->name.' deleted successfully');
            return redirect()->route('nationality.index');
        }

    }
}
