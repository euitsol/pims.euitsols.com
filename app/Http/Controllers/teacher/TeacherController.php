<?php

namespace App\Http\Controllers\teacher;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Teacher;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Bloodgroup;
use App\Models\District;
use App\Models\Division;
use App\Models\TmpFile;
use Illuminate\Support\Facades\Storage;


class TeacherController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $this->check_access('view teacher');
        $n['db_data'] = Teacher::where('deleted_at', null)->orderBy('departments_id')->latest()->get();
        return view('pages.teacher.index',$n);
    }

    //this ajax function for fetch district according to division
    public function ajax($id){

        $data = District::where('division_id',$id)->get();
        return response()->json($data);
    }

    public function create()
    {
        $this->check_access('add teacher');
        $depts = Department::where('deleted_at',null)->latest()->get();;
        $blood_group = Bloodgroup::where('deleted_at',null)->latest()->get();
        $district = District::where('deleted_at',null)->latest()->get();
        $division = Division::where('deleted_at',null)->latest()->get();
        return view('pages.teacher.create',compact('depts','blood_group','district','division'));
    }

    public function store(Request $request)
    {
        $this->check_access('add teacher');
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:teachers,phone|numeric|digits:11',
            'email' => 'required|unique:teachers',
            'departments' => 'required|exists:departments,id',
            'divisions' => 'required|exists:divisions,id',
            'districts' => 'required|exists:districts,id',
            'bloodgroups' => 'required|exists:bloodgroups,id',
            'nid' => 'nullable|unique:teachers,nid',
            'gender' => 'nullable',
            'present_address' => 'nullable',
            'permanant_address' => 'nullable',
            'image' => 'required|exists:tmp_files,id',
            'date_of_birth' => 'required'
        ]);

        $insert = new Teacher;
        $insert->name = $request->name;
        $insert->departments_id = $request->departments;
        $insert->divisions_id = $request->divisions;
        $insert->districts_id = $request->districts;
        $insert->bloodgroups_id = $request->bloodgroups;
        $insert->date_of_birth = $request->date_of_birth;
        $insert->phone = $request->phone;
        $insert->email = $request->email;
        $insert->nid = $request->nid;
        $insert->gender = $request->gender;
        $insert->present_address = $request->present_address;
        $insert->permanant_address = $request->permanant_address;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        //image upload
        $temp_file = TmpFile::findOrFail($request->image);
        if($temp_file){
            $from_path = $temp_file->path.'/'.$temp_file->filename;
            // $from_path = $temp_file->path;
            $to_path = 'public/teacher-info/'.$insert->id.'/photo/'.$temp_file->filename;

            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);

            $insert->photo = $to_path;
            $insert->save();
        }

        $this->message('success', 'Teacher Added Successfullly');
        return redirect()->route('teacher.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $group = Teacher::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($group, 200);
        }
    }

    public function edit($id)
    {
        $this->check_access('edit teacher');
        $n['depts']= Department::where('deleted_at',null)->latest()->get();;
        $n['blood_group']= Bloodgroup::where('deleted_at',null)->latest()->get();;
        $n['district']= District::where('deleted_at',null)->latest()->get();;
        $n['division']= Division::where('deleted_at',null)->latest()->get();;
        $n['db_data'] = Teacher::findOrFail($id);
        return view('pages.teacher.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit teacher');

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:11|unique:teachers,phone,'.$request->id,
            'email' => 'required|unique:teachers,email,'.$request->id,
            'departments' => 'required|exists:departments,id',
            'divisions' => 'required|exists:divisions,id',
            'districts' => 'required|exists:districts,id',
            'bloodgroups' => 'required|exists:bloodgroups,id',
            'nid' => 'nullable|unique:teachers,nid,'.$request->id,
            'gender' => 'nullable',
            'present_address' => 'nullable',
            'permanant_address' => 'nullable',
            'date_of_birth' => 'required'
        ]);

        $update = Teacher::findOrFail($request->id);

        $update->name = $request->name;
        $update->departments_id = $request->departments;
        $update->divisions_id = $request->divisions;
        $update->districts_id = $request->districts;
        $update->bloodgroups_id = $request->bloodgroups;
        $update->date_of_birth = $request->date_of_birth;
        $update->phone = $request->phone;
        $update->email = $request->email;
        $update->nid = $request->nid;
        $update->gender = $request->gender;
        $update->present_address = $request->present_address;
        $update->permanant_address = $request->permanant_address;
        $update->photo = $request->photo;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        if(isset($request->image)){
            $temp_file = TmpFile::findOrFail($request->image);
            $from_path = $temp_file->path.'/'.$temp_file->filename;
            $to_path = 'public/teacher-info/'.$update->id.'/photo/'.$temp_file->filename;
            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);
            $update->photo = $to_path;
        }else{
            $update->photo = $request->pre_photo;
        }
        $update->save();

        $this->message('success', 'Teacher Updated Successfully');
        return redirect()->route('teacher.index');
    }

    public function destroy($id)
    {
        $this->check_access('delete teacher');
        if($id != null){
            $teacher = Teacher::findOrFail($id);
            $teacher->deleted_at = Carbon::now()->toDateTimeString();
            $teacher->deleted_by = auth()->user()->id;
            $teacher->save();
            $this->message('success', 'Teacher '.$teacher->name.' deleted successfully');
            return redirect()->route('teacher.index');
        }

    }

    public function info($id){
        $this->check_access('show teacher');
        $n['db_data'] = Teacher::where('deleted_at', null)
                                ->where('id',$id)->first();
        return view('pages.teacher.show',$n);
    }
}