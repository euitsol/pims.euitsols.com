<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['sections'] = Section::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.section.index',$n);
    }

    public function create(){
        $n['departments'] = Department::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.section.create',$n);
    }

    public function store(Request $req){
        $this->validate($req,[
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|unique:sections,name',
            'short_name' => "nullable|string",
        ],[],['name' => 'section Name','department_id' =>'Department Name','short_name' => "Section's Short Name"]);
        $insert = new Section();
        $insert->department_id = $req->department_id;
        $insert->name = $req->name;
        $insert->short_name = $req->short_name;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Section added successfully');
        return redirect()->route('asset.setup.section.index');
    }

    public function edit($id){
        $n['departments'] = Department::where('deleted_at',null)->latest()->get();
        $n['section'] = Section::findOrFail($id);
        return view('pages.asset.setup.section.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'department_id' => 'required|exists:departments,id',
            'name' => "required|string|unique:sections,name,$req->id,id",
            'short_name' => "nullable|string",
        ],[],['name' => 'section Name','department_id' => 'Department Name','short_name' => "Section's Short Name"]);

        $update = Section::findOrFail($req->id);
        $update->department_id = $req->department_id;
        $update->name = $req->name;
        $update->short_name = $req->short_name;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Section updated successfully');
        return redirect()->route('asset.setup.section.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = Section::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Section deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $section =Section::with(['created_user','updated_user','deleted_user','department'])->find($id);
            return response()->json($section);
        }
    }
}
