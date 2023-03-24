<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\AcademicInfo;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\board;
use App\Models\eadmission;
use App\Models\studentInfo;
use App\Models\Bloodgroup;
use App\Models\Division;
use App\Models\District;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\TmpFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class studentAdmitcontroller extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $n['data'] = studentInfo::with(['created_user', 'updated_user', 'deleted_user', 'academicInfo'])->where('deleted_at', null)->where('status', 0)->latest()->orderBy('departments_id')->get();
        $n['page_name'] = 'Pending Students';

        return view('pages.student.admission.show', $n);
    }

    public function create()
    {
        $n['page_name'] = 'Admit Student';
        $n['department'] = Department::where('deleted_by', '=', null)->get();
        $n['board'] = board::where('deleted_by', '=', null)->get();
        $n['exam_name'] = eadmission::where('deleted_by', '=', null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by', '=', null)->get();
        $n['division'] = Division::where('deleted_by', '=', null)->get();
        return view('pages.student.admission.create', $n);
    }

    public function store(Request $request)
    {
        $rule = [
            'departments_id' => "required|exists:departments,id",
            'name' => "required|string|max:255",
            'father_name' => "required|string|max:255",
            'mother_name' => "required|string|max:255",
            'present_address' => "required|string|max:1000",
            'parmanent_address' => "required|string|max:1000",
            'email' => "required|email|unique:student_infos,email",
            'phone' => "required|unique:student_infos,phone|digits:11",
            'gardian_phone' => "required|digits:11",
            'gender' => "required|string|max:255",
            'dob' => "required|before:today",
            'nationality' => "required|string|max:255",
            'bg_id' => "required|exists:bloodgroups,id",
            'quota' => "nullable",
            'division_id' => "required|exists:divisions,id",
            'district_id' => "required|exists:districts,id",
            'image' => "nullable",

            'exams.*.exam_id' => "required|exists:eadmissions,id",
            'exams.*.passing_year' => "required",
            'exams.*.group' => "required|string|max:255",
            'exams.*.board_id' => "required|exists:boards,id",
            'exams.*.roll' => "required|numeric|unique:academic_infos,roll",
            'exams.*.reg_no' => "required|numeric|unique:academic_infos,reg_no",
            'exams.*.gpa' => "required|numeric",
            'exams.*.reg_card' => "required",
            'exams.*.marksheet' => "required",
        ];
        $msg = [];
        $attribute = [
            'departments_id' => 'Department Name',
            'name' => 'Name',
            'father_name'  => 'Father Name',
            'mother_name'  => 'Mother Name',
            'present_address'  => 'Present Address',
            'parmanent_address'  => 'Permanent Address',
            'email'  => 'Email',
            'phone'  => 'Phone',
            'gardian_phone'  => 'Guardian Phone',
            'gender'  => 'Gender',
            'dob'  => 'Date of Birth',
            'nationality'  => 'Nationality',
            'bg_id'  => 'Blood Group',
            'division_id'  => 'Division',
            'district_id'  => 'District',

            'exams.*.exam_id'  => 'Exam Name',
            'exams.*.passing_year'  => 'Passing Year',
            'exams.*.group'  => 'Group',
            'exams.*.board_id'  => 'Board',
            'exams.*.roll'  => 'Roll',
            'exams.*.reg_no'  => 'Registration Number',
            'exams.*.gpa'  => 'G.P.A',
            'exams.*.reg_card'  => 'Registration Card',
            'exams.*.marksheet'  => 'Marksheet'
        ];

        $this->validate($request, $rule, $msg, $attribute);

        $insert_student_info = new studentInfo;
        $insert_student_info->departments_id = $request->departments_id;
        $insert_student_info->name = $request->name;
        $insert_student_info->father_name = $request->father_name;
        $insert_student_info->mother_name = $request->mother_name;
        $insert_student_info->present_address = $request->present_address;
        $insert_student_info->parmanent_address = $request->parmanent_address;
        $insert_student_info->email = $request->email;
        $insert_student_info->phone = $request->phone;
        $insert_student_info->gardian_phone = $request->gardian_phone;
        $insert_student_info->gender = $request->gender;
        $insert_student_info->dob = $request->dob;
        $insert_student_info->nationality = $request->nationality;
        $insert_student_info->bg_id = $request->bg_id;
        $insert_student_info->quota = $request->quota;
        $insert_student_info->division_id = $request->division_id;
        $insert_student_info->district_id = $request->district_id;
        $insert_student_info->status = 0;
        $insert_student_info->created_by = Auth::user()->id;
        $insert_student_info->created_at = Carbon::now()->toDateTimeString();
        $insert_student_info->save();

        //image upload
        if (isset($request->image) && $request->image != '') {
            $temp_file = TmpFile::findOrFail($request->image);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/student-info/' . $insert_student_info->id . '/photo/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_student_info->photo = $to_path;
                $insert_student_info->save();
            }
        }

        foreach ($request->exams as $key => $data) {
            $insert_academic_info = new AcademicInfo;
            $insert_academic_info->student_infos_id =  $insert_student_info->id;
            $insert_academic_info->exam_id = $data['exam_id'];
            $insert_academic_info->passing_year = $data['passing_year'];
            $insert_academic_info->group = $data['group'];
            $insert_academic_info->board_id = $data['board_id'];
            $insert_academic_info->roll = $data['roll'];
            $insert_academic_info->reg_no = $data['reg_no'];
            $insert_academic_info->gpa = $data['gpa'];
            $insert_academic_info->created_by = Auth::user()->id;
            $insert_academic_info->created_at = Carbon::now()->toDateTimeString();

            //for reg
            $temp_file = TmpFile::findOrFail($data['reg_card']);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/student-info/' . $insert_student_info->id . '/registration/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_academic_info->reg_card = $to_path;
            }

            //for marksheet
            $temp_file = TmpFile::findOrFail($data['marksheet']);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/student-info/' . $insert_student_info->id . '/marksheet/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_academic_info->marksheet = $to_path;
            }

            $insert_academic_info->save();
        }

        $this->message('success', "Student admitted successfully");
        return redirect()->back();
    }

    public function show($id)
    {
        $student = studentInfo::with(['created_user', 'updated_user', 'deleted_user', 'department', 'bloodGroup', 'division', 'district', 'academicInfo'])->where('deleted_at', null)->where('id', $id)->first();
        return view('pages.student.admission.registration', ['student' => $student]);
    }

    public function edit($id)
    {
        $n['page_name'] = 'Edit Pending Student';
        $n['department'] = Department::where('deleted_by', '=', null)->get();
        $n['board'] = board::where('deleted_by', '=', null)->get();
        $n['exam_name'] = eadmission::where('deleted_by', '=', null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by', '=', null)->get();
        $n['division'] = Division::where('deleted_by', '=', null)->get();
        $n['district'] = District::where('deleted_by', '=', null)->get();
        $n['data'] = studentInfo::with(['created_user', 'updated_user', 'deleted_user', 'academicInfo', 'department', 'bloodGroup', 'division', 'district'])->where('id', $id)->first();

        return view('pages.student.admission.edit', $n);
    }

    public function update(Request $request)
    {
        $rule = [
            'departments_id' => "required|exists:departments,id",
            'name' => "required|string|max:255",
            'father_name' => "required|string|max:255",
            'mother_name' => "required|string|max:255",
            'present_address' => "required|string|max:1000",
            'parmanent_address' => "required|string|max:1000",
            'email' => "required|email|unique:student_infos,email,$request->id,id,deleted_at,NULL",
            'phone' => "required|unique:student_infos,phone,$request->id,id,deleted_at,NULL",
            'gardian_phone' => "required|numeric",
            'gender' => "required",
            'dob' => "required",
            'nationality' => "required|string|max:255",
            'bg_id' => "required|exists:bloodgroups,id",
            'quota' => "required",
            'division_id' => "required|exists:divisions,id",
            'district_id' => "required|exists:districts,id",

            'exams.*.exam_id' => "required|exists:eadmissions,id",
            'exams.*.passing_year' => "required",
            'exams.*.group' => "required|string|max:255",
            'exams.*.board_id' => "required|required:boards,id",
            'exams.*.gpa' => "required|numeric|between:0,5.00",
        ];
        $msg = [];
        $attribute = [
            'departments_id' => 'Department Name',
            'name' => 'Name',
            'father_name'  => 'Father Name',
            'mother_name'  => 'Mother Name',
            'present_address'  => 'Present Address',
            'parmanent_address'  => 'Permanent Address',
            'email'  => 'Email',
            'phone'  => 'Phone',
            'gardian_phone'  => 'Guardian Phone',
            'gender'  => 'Gender',
            'dob'  => 'Date of Birth',
            'nationality'  => 'Nationality',
            'bg_id'  => 'Blood Group',
            'division_id'  => 'Division',
            'district_id'  => 'District',

            'exams.*.exam_id'  => 'Exam Name',
            'exams.*.passing_year'  => 'Passing Year',
            'exams.*.group'  => 'Divission',
            'exams.*.board_id'  => 'Board',
            'exams.*.roll'  => 'Roll',
            'exams.*.reg_no'  => 'Registration Number',
            'exams.*.gpa'  => 'G.P.A',
        ];
        $this->validate($request, $rule, $msg, $attribute);

        foreach ($request->exams as $data) {
            if (!isset($data['pre_reg_card']) && !isset($data['reg_card'])) {
                $this->validate($request, ['exams.*.reg_card' => 'required'], [''], ['exams.*.reg_card'  => 'Registration Card']);
            }
            if (!isset($data['pre_marksheet']) && !isset($data['marksheet'])) {
                $this->validate($request, ['exams.*.marksheet' => 'required'], [''], ['exams.*.marksheet'  => 'Marksheet']);
            }
        }

        AcademicInfo::where('student_infos_id', $request->id)->delete();

        $update_student_info = studentInfo::find($request->id);
        $update_student_info->departments_id = $request->departments_id;
        $update_student_info->name = $request->name;
        $update_student_info->father_name = $request->father_name;
        $update_student_info->mother_name = $request->mother_name;
        $update_student_info->present_address = $request->present_address;
        $update_student_info->parmanent_address = $request->parmanent_address;
        $update_student_info->email = $request->email;
        $update_student_info->phone = $request->phone;
        $update_student_info->gardian_phone = $request->gardian_phone;
        $update_student_info->gender = $request->gender;
        $update_student_info->dob = $request->dob;
        $update_student_info->nationality = $request->nationality;
        $update_student_info->bg_id = $request->bg_id;
        $update_student_info->quota = $request->quota;
        $update_student_info->division_id = $request->division_id;
        $update_student_info->district_id = $request->district_id;
        $update_student_info->updated_at = Carbon::now()->toDateTimeString();
        $update_student_info->updated_by = auth()->user()->id;
        $update_student_info->save();

        // image upload
        if (isset($request->image)) {
            $temp_file = TmpFile::findOrFail($request->image);
            $from_path = $temp_file->path . '/' . $temp_file->filename;
            $to_path = 'public/student-info/' . $update_student_info->id . '/photo/' . $temp_file->filename;
            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);
            $update_student_info->photo = $to_path;
        } else {
            $update_student_info->photo = $request->pre_photo;
        }
        $update_student_info->save();

        foreach ($request->exams as $data) {
            $update_academic_info = new AcademicInfo;
            $update_academic_info->student_infos_id =  $update_student_info->id;
            $update_academic_info->exam_id = $data['exam_id'];
            $update_academic_info->passing_year = $data['passing_year'];
            $update_academic_info->group = $data['group'];
            $update_academic_info->board_id = $data['board_id'];
            $update_academic_info->roll = $data['roll'];
            $update_academic_info->reg_no = $data['reg_no'];
            $update_academic_info->gpa = $data['gpa'];
            $update_academic_info->created_by = Auth::user()->id;
            $update_academic_info->created_at = Carbon::now()->toDateTimeString();
            $update_academic_info->save();

            //for reg
            if (isset($data['pre_reg_card'])) {
                if (isset($data['reg_card'])) {
                    $temp_file = TmpFile::findOrFail($data['reg_card']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/student-info/' . $update_student_info->id . '/registration/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->reg_card = $to_path;
                } else {
                    $update_academic_info->reg_card = $data['pre_reg_card'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['reg_card']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/student-info/' . $update_student_info->id . '/registration/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_academic_info->reg_card = $to_path;
            }
            if (isset($data['pre_marksheet'])) {
                if (isset($data['marksheet'])) {
                    $temp_file = TmpFile::findOrFail($data['marksheet']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/student-info/' . $update_student_info->id . '/marksheet/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->marksheet = $to_path;
                } else {
                    $update_academic_info->marksheet = $data['pre_marksheet'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['marksheet']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/student-info/' . $update_student_info->id . '/marksheet/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_academic_info->marksheet = $to_path;
            }
            $update_academic_info->save();
        }
        $this->message('success', "Pending student updated successfully");
        return redirect()->back();
    }
    public function delete($id)
    {
        $this->check_access('delete subject-ssign');
        $delete = studentInfo::where('deleted_at', null)->where('id', $id)->first();
        $delete->deleted_at = Carbon::now()->toDateTimeString();
        $delete->deleted_by = Auth::user()->id;
        $delete->save();
        $this->message('success', 'Pending student successfully deleted');
        return redirect()->route('student.student-admit.index');
    }

    public function ajax($id)
    {
        $data = District::where('division_id', $id)->get();
        return response()->json($data);
    }

    public function student_reg_download($id)
    {
        $data = AcademicInfo::findOrFail($id);

        if (Storage::exists($data->reg_card)) {
            $path = Storage::path($data->reg_card);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }

    public function student_marksheet_download($id)
    {
        $data = AcademicInfo::findOrFail($id);

        if (Storage::exists($data->marksheet)) {
            $path = Storage::path($data->marksheet);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }

    public function decline_student($id)
    {
        $data = studentInfo::findOrFail($id);
        $data->status = -1;
        $data->save();

        $this->message('success', 'Student ' . $data->name . ' Declined Successfully');
        return redirect()->route('student.student-admit.index');
    }

    public function decline_list(Request $request)
    {
        $n['data'] = studentInfo::with(['created_user', 'updated_user', 'deleted_user', 'academicInfo'])->where('deleted_at', null)->where('status', -1)->latest()->orderBy('departments_id')->get();
        $n['page_name'] = 'Declined Students';

        return view('pages.student.decline.show', $n);
    }
    public function decline_edit($id)
    {
        $n['page_name'] = 'Edit Declined Student';
        $n['department'] = Department::where('deleted_by', '=', null)->get();
        $n['board'] = board::where('deleted_by', '=', null)->get();
        $n['exam_name'] = eadmission::where('deleted_by', '=', null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by', '=', null)->get();
        $n['division'] = Division::where('deleted_by', '=', null)->get();
        $n['district'] = District::where('deleted_by', '=', null)->get();
        $n['data'] = studentInfo::with(['created_user', 'updated_user', 'deleted_user', 'academicInfo', 'department', 'bloodGroup', 'division', 'district'])->where('id', $id)->first();

        return view('pages.student.decline.edit', $n);
    }
    public function decline_update(Request $request)
    {
        $rule = [
            'departments_id' => "required|exists:departments,id",
            'name' => "required|string|max:255",
            'father_name' => "required|string|max:255",
            'mother_name' => "required|string|max:255",
            'present_address' => "required|string|max:1000",
            'parmanent_address' => "required|string|max:1000",
            'email' => "required|email|unique:student_infos,email,$request->id,id,deleted_at,NULL",
            'phone' => "required|unique:student_infos,phone,$request->id,id,deleted_at,NULL",
            'gardian_phone' => "required|numeric",
            'gender' => "required",
            'dob' => "required",
            'nationality' => "required|string|max:255",
            'bg_id' => "required|exists:bloodgroups,id",
            'quota' => "required",
            'division_id' => "required|exists:divisions,id",
            'district_id' => "required|exists:districts,id",

            'exams.*.exam_id' => "required|exists:eadmissions,id",
            'exams.*.passing_year' => "required",
            'exams.*.group' => "required|string|max:255",
            'exams.*.board_id' => "required|required:boards,id",
            'exams.*.gpa' => "required|numeric|between:0,5.00",
        ];
        $msg = [];
        $attribute = [
            'departments_id' => 'Department Name',
            'name' => 'Name',
            'father_name'  => 'Father Name',
            'mother_name'  => 'Mother Name',
            'present_address'  => 'Present Address',
            'parmanent_address'  => 'Permanent Address',
            'email'  => 'Email',
            'phone'  => 'Phone',
            'gardian_phone'  => 'Guardian Phone',
            'gender'  => 'Gender',
            'dob'  => 'Date of Birth',
            'nationality'  => 'Nationality',
            'bg_id'  => 'Blood Group',
            'division_id'  => 'Division',
            'district_id'  => 'District',

            'exams.*.exam_id'  => 'Exam Name',
            'exams.*.passing_year'  => 'Passing Year',
            'exams.*.group'  => 'Divission',
            'exams.*.board_id'  => 'Board',
            'exams.*.roll'  => 'Roll',
            'exams.*.reg_no'  => 'Registration Number',
            'exams.*.gpa'  => 'G.P.A',
        ];
        $this->validate($request, $rule, $msg, $attribute);

        foreach ($request->exams as $data) {
            if (!isset($data['pre_reg_card']) && !isset($data['reg_card'])) {
                $this->validate($request, ['exams.*.reg_card' => 'required'], [''], ['exams.*.reg_card'  => 'Registration Card']);
            }
            if (!isset($data['pre_marksheet']) && !isset($data['marksheet'])) {
                $this->validate($request, ['exams.*.marksheet' => 'required'], [''], ['exams.*.marksheet'  => 'Marksheet']);
            }
        }

        AcademicInfo::where('student_infos_id', $request->id)->delete();

        $update_student_info = studentInfo::find($request->id);
        $update_student_info->departments_id = $request->departments_id;
        $update_student_info->name = $request->name;
        $update_student_info->father_name = $request->father_name;
        $update_student_info->mother_name = $request->mother_name;
        $update_student_info->present_address = $request->present_address;
        $update_student_info->parmanent_address = $request->parmanent_address;
        $update_student_info->email = $request->email;
        $update_student_info->phone = $request->phone;
        $update_student_info->gardian_phone = $request->gardian_phone;
        $update_student_info->gender = $request->gender;
        $update_student_info->dob = $request->dob;
        $update_student_info->nationality = $request->nationality;
        $update_student_info->bg_id = $request->bg_id;
        $update_student_info->quota = $request->quota;
        $update_student_info->division_id = $request->division_id;
        $update_student_info->district_id = $request->district_id;
        $update_student_info->updated_at = Carbon::now()->toDateTimeString();
        $update_student_info->updated_by = auth()->user()->id;
        $update_student_info->status = 0;
        $update_student_info->save();

        // image upload
        if (isset($request->image)) {
            $temp_file = TmpFile::findOrFail($request->image);
            $from_path = $temp_file->path . '/' . $temp_file->filename;
            $to_path = 'public/student-info/' . $update_student_info->id . '/photo/' . $temp_file->filename;
            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);
            $update_student_info->photo = $to_path;
        } else {
            $update_student_info->photo = $request->pre_photo;
        }
        $update_student_info->save();

        foreach ($request->exams as $data) {
            $update_academic_info = new AcademicInfo;
            $update_academic_info->student_infos_id =  $update_student_info->id;
            $update_academic_info->exam_id = $data['exam_id'];
            $update_academic_info->passing_year = $data['passing_year'];
            $update_academic_info->group = $data['group'];
            $update_academic_info->board_id = $data['board_id'];
            $update_academic_info->roll = $data['roll'];
            $update_academic_info->reg_no = $data['reg_no'];
            $update_academic_info->gpa = $data['gpa'];
            $update_academic_info->created_by = Auth::user()->id;
            $update_academic_info->created_at = Carbon::now()->toDateTimeString();
            $update_academic_info->save();

            //for reg
            if (isset($data['pre_reg_card'])) {
                if (isset($data['reg_card'])) {
                    $temp_file = TmpFile::findOrFail($data['reg_card']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/student-info/' . $update_student_info->id . '/registration/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->reg_card = $to_path;
                } else {
                    $update_academic_info->reg_card = $data['pre_reg_card'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['reg_card']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/student-info/' . $update_student_info->id . '/registration/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_academic_info->reg_card = $to_path;
            }
            if (isset($data['pre_marksheet'])) {
                if (isset($data['marksheet'])) {
                    $temp_file = TmpFile::findOrFail($data['marksheet']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/student-info/' . $update_student_info->id . '/marksheet/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->marksheet = $to_path;
                } else {
                    $update_academic_info->marksheet = $data['pre_marksheet'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['marksheet']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/student-info/' . $update_student_info->id . '/marksheet/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_academic_info->marksheet = $to_path;
            }
            $update_academic_info->save();
        }
        $this->message('success', "Declined Student Updated successfully");
        return redirect()->back();
        // return redirect()->route('student.student-admit.index');
    }
    public function decline_show($id)
    {
        $student = studentInfo::with(['created_user', 'updated_user', 'deleted_user', 'department', 'bloodGroup', 'division', 'district', 'academicInfo'])->where('deleted_at', null)->where('id', $id)->first();
        return view('pages.student.decline.declinedinfo', ['student' => $student]);
    }
}