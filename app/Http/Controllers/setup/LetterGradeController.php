<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Lettergrade;

class LetterGradeController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $this->check_access('view letter-grade');
        $n['db_data'] = Lettergrade::where('deleted_at', null)->latest()->get();
        return view('pages.setup.lettergrade.index',$n);
    }

    public function create()
    {
        $this->check_access('add letter-grade');
        return view('pages.setup.lettergrade.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add letter-grade');
        $this->validate($request, [
            'name' => 'required|unique:lettergrades,name|string|max:255',
        ]);

        $insert = new lettergrade;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Letter Grade Created Successfullly');
        return redirect()->route('lettergrade.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Lettergrade::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit letter-grade');
        $n['db_data'] = Lettergrade::findOrFail($id);
        return view('pages.setup.lettergrade.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit letter-grade');
        $this->validate($request, [
            'id' => 'required|exists:lettergrades,id',
        ]);

        $update = Lettergrade::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:lettergrades,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Letter Grade Updated Successfully');
        return redirect()->route('lettergrade.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete letter-grade');
        if($id != null){
            $lettergrade = Lettergrade::findOrFail($id);
            $lettergrade->deleted_at = Carbon::now()->toDateTimeString();
            $lettergrade->deleted_by = auth()->user()->id;
            $lettergrade->save();
            $this->message('success', 'Letter Grade '.$lettergrade->name.' deleted successfully');
            return redirect()->route('lettergrade.index');
        }

    }
}
