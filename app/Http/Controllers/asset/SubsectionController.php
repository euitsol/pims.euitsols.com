<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Subsection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubsectionController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['subsections'] = Subsection::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.subsection.index',$n);
    }

    public function create(){
        $n['sections'] = Section::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.subsection.create',$n);
    }

    public function store(Request $req){
        $this->validate($req,[
            'section_id' => 'required|exists:sections,id',
            'name' => 'required|string|unique:subsections,name',
            'short_name' => "nullable|string",
        ],[],['name' => 'Sub-section Name','section_id' =>'Section Name','short_name' => "Sub-section's Short Name"]);
        $insert = new Subsection();
        $insert->section_id = $req->section_id;
        $insert->name = $req->name;
        $insert->short_name = $req->short_name;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Sub-section added successfully');
        return redirect()->route('asset.setup.subsection.index');
    }

    public function edit($id){
        $n['sections'] = section::where('deleted_at',null)->latest()->get();
        $n['subsection'] = subsection::findOrFail($id);
        return view('pages.asset.setup.subsection.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'section_id' => 'required|exists:sections,id',
            'name' => "required|string|unique:subsections,name,$req->id,id",
            'short_name' => "nullable|string",
        ],[],['name' => 'Sub-section Name','section_id' => 'Section Name','short_name' => "Sub-section's Short Name"]);

        $update = subsection::findOrFail($req->id);
        $update->section_id = $req->section_id;
        $update->name = $req->name;
        $update->short_name = $req->short_name;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Sub-section updated successfully');
        return redirect()->route('asset.setup.subsection.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = subsection::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Sub-section deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $subsection =subsection::with(['created_user','updated_user','deleted_user','section'])->find($id);
            return response()->json($subsection);
        }
    }
}
