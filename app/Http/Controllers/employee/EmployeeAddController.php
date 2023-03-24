<?php

namespace App\Http\Controllers\employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\board;
use App\Models\eadmission;
use App\Models\employeeInfos;
use App\Models\Bloodgroup;
use App\Models\Division;
use App\Models\District;
use App\Models\employeeAcademicInfos;
use App\Models\employeeDocuments;
use App\Models\employeeExperiences;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\TmpFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
class EmployeeAddController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
  

    public function index()
    {
        $n['data'] = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'employeeAcademicInfo','employeeExperience', 'employeeDocument'])->where('deleted_at', null)->where('status', 0)->latest()->orderBy('departments_id')->get();
        $n['page_name'] = 'Pending Employee';

        return view('pages.employee.employee_add.show', $n);
    }


    public function create()
    {
        $n['page_name'] = 'Employee';
        $n['department'] = Department::where('deleted_by', '=', null)->get();
        $n['designation'] = Designation::where('deleted_by', '=', null)->get();
        $n['board'] = board::where('deleted_by', '=', null)->get();
        $n['exam_name'] = eadmission::where('deleted_by', '=', null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by', '=', null)->get();
        $n['division'] = Division::where('deleted_by', '=', null)->get();
        return view('pages.employee.employee_add.create', $n);
    }


    public function store(Request $request)
    {
        $rule = [
            'departments_id' => "required|exists:departments,id",

            // Employee Personal Data
            'name' => "required|string|max:255",
            'father_name' => "required|string|max:255",
            'mother_name' => "required|string|max:255",
            'present_address' => "required|string|max:1000",
            'parmanent_address' => "required|string|max:1000",
            'email' => "required|email|unique:employee_infos,email",
            'phone' => "required|unique:employee_infos,phone|digits:11",
            'gender' => "required|string|max:255",
            'm_status'=> 'required|in:single,married',
            'spouse_name' => "nullable",
            'spouse_number' => "nullable",
            'dob' => "required|before:today",
            'nationality' => "required|string|max:255",
            'bg_id' => "required|exists:bloodgroups,id",
            'division_id' => "required|exists:divisions,id",
            'district_id' => "required|exists:districts,id",
            'image' => "nullable",

            // Employee Academic Infos
            'exams.*.exam_id' => "required|exists:eadmissions,id",
            'exams.*.passing_year' => "required",
            'exams.*.group' => "required|string|max:255",
            'exams.*.board_id' => "required|exists:boards,id",
            'exams.*.roll' => "required|numeric|unique:employee_academic_infos,roll",
            'exams.*.reg_no' => "required|numeric|unique:employee_academic_infos,reg_no",
            'exams.*.gpa' => "required|numeric",
            'exams.*.reg_card' => "required",
            'exams.*.marksheet' => "required",
            'exams.*.certificate' => "required",

            // Employee Work Experience Data
            'experience.*.job_designation' => "string|max:255|nullable",
            'experience.*.company' => "string|max:255|nullable",
            'experience.*.start_month' => "nullable",
            'experience.*.end_month' => "nullable",
            'experience.*.ec' => "nullable",

            // Employee Documents
            'document.*.designation_id' => "required|exists:designations,id",
            'document.*.nidordob_card' => "required",
            'document.*.cv' => "required",
            'document.*.cc' => "required"

        ];
        $msg = [];
        $attribute = [
            'departments_id' => 'Employee Department Name',

            // Employee Personal Data
            'name' => 'Employee Name',
            'father_name'  => 'Employee Father Name',
            'mother_name'  => 'Employee Mother Name',
            'present_address'  => 'Employee Present Address',
            'parmanent_address'  => 'Employee Permanent Address',
            'email'  => 'Employee Email',
            'phone'  => 'Employee Phone',
            'gender'  => 'Employee Gender',
            'm_status'=> 'Employee Marital Status',
            'dob'  => 'Employee Date of Birth',
            'nationality'  => 'Employee Nationality',
            'bg_id'  => 'Employee Blood Group',
            'division_id'  => 'Employee Division',
            'district_id'  => 'Employee District',

            // Employee Academic Infos
            'exams.*.exam_id'  => 'Employee Exam Name',
            'exams.*.passing_year'  => 'Employee Passing Year',
            'exams.*.group'  => 'Employee Group',
            'exams.*.board_id'  => 'Employee Board',
            'exams.*.roll'  => 'Employee Roll',
            'exams.*.reg_no'  => 'Employee Registration Number',
            'exams.*.gpa'  => 'Employee G.P.A',
            'exams.*.reg_card'  => 'Employee Registration Card',
            'exams.*.marksheet'  => 'Employee Marksheet',
            'exams.*.certificate' => 'Employee Certificate',

            // Employee Work Experience Data
            'experience.*.job_designation' => 'Employee Job Designation',
            'experience.*.company' => 'Employee Company Name',
            'experience.*.start_month' => 'Employee Start Month',
            'experience.*.end_month' => 'Employee End Month',
            'experience.*.ec' => 'Employee Experience Certificate',

            // Employee Documents
            'document.*.designation_id' => 'Employee New Designation',
            'document.*.nidordob_card' => 'Employee NID Card or Birth Certificate',
            'document.*.cv' => "Employee CV",
            'document.*.cc' => "Employee Character Certificate"
        ];

        $this->validate($request, $rule, $msg, $attribute);

        $insert_employee_info = new employeeInfos;
        $insert_employee_info->departments_id = $request->departments_id;
        $insert_employee_info->name = $request->name;
        $insert_employee_info->father_name = $request->father_name;
        $insert_employee_info->mother_name = $request->mother_name;
        $insert_employee_info->present_address = $request->present_address;
        $insert_employee_info->parmanent_address = $request->parmanent_address;
        $insert_employee_info->email = $request->email;
        $insert_employee_info->phone = $request->phone;

        $insert_employee_info->gender = $request->gender;
        $insert_employee_info->marital_status = $request->m_status;
        $insert_employee_info->spouse_name = $request->spouse_name;
        $insert_employee_info->spouse_number = $request->spouse_number;
        $insert_employee_info->dob = $request->dob;
        $insert_employee_info->nationality = $request->nationality;
        $insert_employee_info->bg_id = $request->bg_id;

        $insert_employee_info->division_id = $request->division_id;
        $insert_employee_info->district_id = $request->district_id;
        $insert_employee_info->status = 0;
        $insert_employee_info->created_by = Auth::user()->id;
        $insert_employee_info->created_at = Carbon::now()->toDateTimeString();
        $insert_employee_info->save();

        //image upload
        if (isset($request->image) && $request->image != '') {
            $temp_file = TmpFile::findOrFail($request->image);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $insert_employee_info->id . '/photo/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_employee_info->photo = $to_path;
                $insert_employee_info->save();
            }
        }

        // Employee Academic Infos
        foreach ($request->exams as $key => $data) {
            $insert_employee_academic_info = new employeeAcademicInfos;
            $insert_employee_academic_info->employee_infos_id =  $insert_employee_info->id;
            $insert_employee_academic_info->exam_id = $data['exam_id'];
            $insert_employee_academic_info->passing_year = $data['passing_year'];
            $insert_employee_academic_info->group = $data['group'];
            $insert_employee_academic_info->board_id = $data['board_id'];
            $insert_employee_academic_info->roll = $data['roll'];
            $insert_employee_academic_info->reg_no = $data['reg_no'];
            $insert_employee_academic_info->gpa = $data['gpa'];
            $insert_employee_academic_info->created_by = Auth::user()->id;
            $insert_employee_academic_info->created_at = Carbon::now()->toDateTimeString();

            //for reg
            $temp_file = TmpFile::findOrFail($data['reg_card']);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $insert_employee_info->id . '/registration/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_employee_academic_info->reg_card = $to_path;
            }

            //for marksheet
            $temp_file = TmpFile::findOrFail($data['marksheet']);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $insert_employee_info->id . '/marksheet/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_employee_academic_info->marksheet = $to_path;
            }

            //for certificate
            $temp_file = TmpFile::findOrFail($data['certificate']);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $insert_employee_info->id . '/certificate/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_employee_academic_info->certificate = $to_path;
            }

            $insert_employee_academic_info->save();
        }


        // Employee Work Experience Data
        foreach ($request->experience as $key => $data) {
            $insert_employee_experience_info = new employeeExperiences;
            $insert_employee_experience_info->employee_infos_id =  $insert_employee_info->id;
            $insert_employee_experience_info->designation = $data['job_designation'];
            $insert_employee_experience_info->company_name = $data['company'];
            $insert_employee_experience_info->job_start = $data['start_month'];
            $insert_employee_experience_info->job_end = $data['end_month'];
            $insert_employee_experience_info->created_by = Auth::user()->id;
            $insert_employee_experience_info->created_at = Carbon::now()->toDateTimeString();

            //for experience Certificate
            if (isset($data['ec']) && $data['ec'] != '') {
                $temp_file = TmpFile::findOrFail($data['ec']);
                if ($temp_file) {
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $insert_employee_info->id . '/ex_certificate/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $insert_employee_experience_info->ex_certificate = $to_path;
                }
                $insert_employee_experience_info->save();
            }
        }



        // Employee Documents
        foreach ($request->document as $key => $data) {
            $insert_employee_document_info = new employeeDocuments;
            $insert_employee_document_info->employee_infos_id =  $insert_employee_info->id;
            $insert_employee_document_info->designation_id = $data['designation_id'];
            $insert_employee_document_info->created_by = Auth::user()->id;
            $insert_employee_document_info->created_at = Carbon::now()->toDateTimeString();

            //for NID or Birth Certificate
            $temp_file = TmpFile::findOrFail($data['nidordob_card']);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $insert_employee_info->id . '/nid_or_dob/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_employee_document_info->nid_or_dob = $to_path;
            }
            //for CV
            $temp_file = TmpFile::findOrFail($data['cv']);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $insert_employee_info->id . '/cv/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_employee_document_info->cv = $to_path;
            }
            //for Character Certificate
            $temp_file = TmpFile::findOrFail($data['cc']);
            if ($temp_file) {
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $insert_employee_info->id . '/character_certificate/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_employee_document_info->character_certificate = $to_path;
            }

            $insert_employee_document_info->save();
        }

        $this->message('success', "Employee add successfully");
        return redirect()->back();

    }


    public function show($id)
    {
        $employee = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'department', 'bloodGroup', 'division', 'district', 'employeeAcademicInfo','employeeExperience', 'employeeDocument'])->where('deleted_at', null)->where('id', $id)->first();
        return view('pages.employee.employee_add.registration', ['employee' => $employee]);
    }


    public function edit($id)
    {
        $n['page_name'] = 'Edit Pending Employee';
        $n['department'] = Department::where('deleted_by', '=', null)->get();
        $n['board'] = board::where('deleted_by', '=', null)->get();
        $n['exam_name'] = eadmission::where('deleted_by', '=', null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by', '=', null)->get();
        $n['designation'] = Designation::where('deleted_by', '=', null)->get();
        $n['division'] = Division::where('deleted_by', '=', null)->get();
        $n['district'] = District::where('deleted_by', '=', null)->get();
        $n['data'] = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'employeeAcademicInfo','employeeExperience', 'employeeDocument','department', 'bloodGroup', 'division', 'district'])->where('id', $id)->first();

        return view('pages.employee.employee_add.edit', $n);
    }


    public function update(Request $request, $id)
    {
        $rule = [
            'departments_id' => "required|exists:departments,id",

            // Employee Personal Data
            'name' => "required|string|max:255",
            'father_name' => "required|string|max:255",
            'mother_name' => "required|string|max:255",
            'present_address' => "required|string|max:1000",
            'parmanent_address' => "required|string|max:1000",
            'email' => "required|email|unique:employee_infos,email,$request->id,id,deleted_at,NULL",
            'phone' => "required|unique:employee_infos,phone,$request->id,id,deleted_at,NULL",
            'gender' => "required|string|max:255",
            'm_status'=> 'required|in:single,married',
            'spouse_name' => "nullable",
            'spouse_number' => "nullable",
            'dob' => "required|before:today",
            'nationality' => "required|string|max:255",
            'bg_id' => "required|exists:bloodgroups,id",
            'division_id' => "required|exists:divisions,id",
            'district_id' => "required|exists:districts,id",

            // Employee Academic Infos
            'exams.*.exam_id' => "required|exists:eadmissions,id",
            'exams.*.passing_year' => "required",
            'exams.*.group' => "required|string|max:255",
            'exams.*.board_id' => "required|exists:boards,id",
            'exams.*.gpa' => "required|numeric|between:0,5.00",

            // Employee Work Experience Data
            'experience.*.job_designation' => "string|max:255|nullable",
            'experience.*.company' => "string|max:255|nullable",
            'experience.*.start_month' => "nullable",
            'experience.*.end_month' => "nullable",

            // Employee Documents
            'document.*.designation_id' => "required|exists:designations,id"

        ];
        $msg = [];
        $attribute = [
            'departments_id' => 'Employee Department Name',

            // Employee Personal Data
            'name' => 'Employee Name',
            'father_name'  => 'Employee Father Name',
            'mother_name'  => 'Employee Mother Name',
            'present_address'  => 'Employee Present Address',
            'parmanent_address'  => 'Employee Permanent Address',
            'email'  => 'Employee Email',
            'phone'  => 'Employee Phone',
            'gender'  => 'Employee Gender',
            'm_status'=> 'Employee Marital Status',
            'dob'  => 'Employee Date of Birth',
            'nationality'  => 'Employee Nationality',
            'bg_id'  => 'Employee Blood Group',
            'division_id'  => 'Employee Division',
            'district_id'  => 'Employee District',

            // Employee Academic Infos
            'exams.*.exam_id'  => 'Employee Exam Name',
            'exams.*.passing_year'  => 'Employee Passing Year',
            'exams.*.group'  => 'Employee Group',
            'exams.*.board_id'  => 'Employee Board',
            'exams.*.roll'  => 'Employee Roll',
            'exams.*.reg_no'  => 'Employee Registration Number',
            'exams.*.gpa'  => 'Employee G.P.A',

            // Employee Work Experience Data
            'experience.*.job_designation' => 'Employee Job Designation',
            'experience.*.company' => 'Employee Company Name',
            'experience.*.start_month' => 'Employee Start Month',
            'experience.*.end_month' => 'Employee End Month',

            // Employee Documents
            'document.*.designation_id' => 'Employee New Designation',
        ];

        $this->validate($request, $rule, $msg, $attribute);

         foreach ($request->exams as $data) {
            if (!isset($data['pre_reg_card']) && !isset($data['reg_card'])) {
                $this->validate($request, ['exams.*.reg_card' => 'required'], [''], ['exams.*.reg_card'  => 'Employee Registration Card']);
            }
            if (!isset($data['pre_marksheet']) && !isset($data['marksheet'])) {
                $this->validate($request, ['exams.*.marksheet' => 'required'], [''], ['exams.*.marksheet'  => 'Employee Marksheet']);
            }
            if (!isset($data['pre_certificate']) && !isset($data['certificate'])) {
                $this->validate($request, ['exams.*.certificate' => 'required'], [''], ['exams.*.certificate'  => 'Employee Certificate']);
            }
        }
        employeeAcademicInfos::where('employee_infos_id', $request->id)->delete();

        // foreach ($request->experience as $data) {
        //     if (!isset($data['pre_ec']) && !isset($data['ec'])) {
        //         $this->validate($request, ['experience.*.ec' => 'required'], [''], ['experience.*.ec'  => 'Employee Experience Certificate']);
        //     }
        // }
        employeeExperiences::where('employee_infos_id', $request->id)->delete();

        foreach ($request->document as $data) {
            if (!isset($data['pre_nidordob_card']) && !isset($data['nidordob_card'])) {
                $this->validate($request, ['document.*.nidordob_card' => 'required'], [''], ['document.*.nidordob_card'  => 'Employee NID Card or Birth Certificate']);
            }
            if (!isset($data['pre_cv']) && !isset($data['cv'])) {
                $this->validate($request, ['document.*.cv' => 'required'], [''], ['document.*.cv'  => 'Employee CV']);
            }
            if (!isset($data['pre_cc']) && !isset($data['cc'])) {
                $this->validate($request, ['document.*.cc' => 'required'], [''], ['document.*.cc'  => 'Employee Character Certificate']);
            }
        }
        employeeDocuments::where('employee_infos_id', $request->id)->delete();

        $update_employee_info = employeeInfos::find($request->id);;
        $update_employee_info->departments_id = $request->departments_id;
        $update_employee_info->name = $request->name;
        $update_employee_info->father_name = $request->father_name;
        $update_employee_info->mother_name = $request->mother_name;
        $update_employee_info->present_address = $request->present_address;
        $update_employee_info->parmanent_address = $request->parmanent_address;
        $update_employee_info->email = $request->email;
        $update_employee_info->phone = $request->phone;

        $update_employee_info->gender = $request->gender;
        $update_employee_info->marital_status = $request->m_status;
        $update_employee_info->spouse_name = $request->spouse_name;
        $update_employee_info->spouse_number = $request->spouse_number;
        $update_employee_info->dob = $request->dob;
        $update_employee_info->nationality = $request->nationality;
        $update_employee_info->bg_id = $request->bg_id;

        $update_employee_info->division_id = $request->division_id;
        $update_employee_info->district_id = $request->district_id;
        $update_employee_info->created_by = Auth::user()->id;
        $update_employee_info->created_at = Carbon::now()->toDateTimeString();
        $update_employee_info->save();

        //image upload
        if (isset($request->image)) {
            $temp_file = TmpFile::findOrFail($request->image);
            $from_path = $temp_file->path . '/' . $temp_file->filename;
            $to_path = 'public/employee-info/' . $update_employee_info->id . '/photo/' . $temp_file->filename;
            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);
            $update_employee_info->photo = $to_path;
        }
        else {
            $update_employee_info->photo = $request->pre_photo;
        }
        $update_employee_info->save();


        // Employee Academic Infos
        foreach ($request->exams as $key => $data) {
            $update_employee_academic_info = new employeeAcademicInfos;
            $update_employee_academic_info->employee_infos_id =  $update_employee_info->id;
            $update_employee_academic_info->exam_id = $data['exam_id'];
            $update_employee_academic_info->passing_year = $data['passing_year'];
            $update_employee_academic_info->group = $data['group'];
            $update_employee_academic_info->board_id = $data['board_id'];
            $update_employee_academic_info->roll = $data['roll'];
            $update_employee_academic_info->reg_no = $data['reg_no'];
            $update_employee_academic_info->gpa = $data['gpa'];
            $update_employee_academic_info->created_by = Auth::user()->id;
            $update_employee_academic_info->created_at = Carbon::now()->toDateTimeString();
            $update_employee_academic_info->save();
            //for reg
            if (isset($data['pre_reg_card'])) {
                if (isset($data['reg_card'])) {
                    $temp_file = TmpFile::findOrFail($data['reg_card']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/registration/' . $key . '/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->reg_card = $to_path;
                    } else {
                        $update_employee_academic_info->reg_card = $data['pre_reg_card'];
                    }
            } else {
                $temp_file = TmpFile::findOrFail($data['reg_card']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/registration/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->reg_card = $to_path;
            }
            //for marksheet
            if (isset($data['pre_marksheet'])) {
                if (isset($data['marksheet'])) {
                    $temp_file = TmpFile::findOrFail($data['marksheet']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/marksheet/' . $key . '/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->marksheet = $to_path;
                } else {
                    $update_employee_academic_info->marksheet = $data['pre_marksheet'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['marksheet']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/marksheet/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->marksheet = $to_path;
            }

            //for certificate

            // if (isset($data['certificate'])) {
            //     $temp_file = TmpFile::findOrFail($data['certificate']);
            //     $from_path = $temp_file->path . '/' . $temp_file->filename;
            //     $to_path = 'public/employee-info/' . $update_employee_info->id . '/certificate/' . $key . '/'  . $temp_file->filename;
            //     Storage::move($from_path, $to_path);
            //     Storage::deleteDirectory($temp_file->path);
            //     $update_employee_academic_info->certificate = $to_path;
            // }
            // else {
            //     $update_employee_academic_info->certificate = $data['pre_certificate'];
            // }

            if (isset($data['pre_certificate'])) {
                if (isset($data['certificate'])) {
                    $temp_file = TmpFile::findOrFail($data['certificate']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->certificate = $to_path;
                } else {
                    $update_employee_academic_info->certificate = $data['pre_certificate'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['certificate']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/certificate/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->certificate = $to_path;
            }
            $update_employee_academic_info->save();
        }


        // Employee Work Experience Data
        if($request->experience){
            foreach ($request->experience as $key => $data) {
                $update_employee_experience_info = new employeeExperiences;
                $update_employee_experience_info->employee_infos_id =  $update_employee_info->id;
                $update_employee_experience_info->designation = $data['job_designation'];
                $update_employee_experience_info->company_name = $data['company'];
                $update_employee_experience_info->job_start = $data['start_month'];
                $update_employee_experience_info->job_end = $data['end_month'];
                $update_employee_experience_info->created_by = Auth::user()->id;
                $update_employee_experience_info->created_at = Carbon::now()->toDateTimeString();
                $update_employee_experience_info->save();

                //for experience Certificate
                // if (isset($data['pre_ec'])) {
                //     if (isset($data['ec'])) {
                //         $temp_file = TmpFile::findOrFail($data['ec']);
                //         $from_path = $temp_file->path . '/' . $temp_file->filename;
                //         $to_path = 'public/employee-info/' . $update_employee_info->id . '/ex_certificate/' . $key . '/'  . $temp_file->filename;
                //         Storage::move($from_path, $to_path);
                //         Storage::deleteDirectory($temp_file->path);
                //         $update_employee_experience_info->ex_certificate = $to_path;
                //     }else {
                //         $update_employee_experience_info->ex_certificate = $data['pre_ec'];
                //     }
                // } else {
                //     $temp_file = TmpFile::findOrFail($data['ec']);
                //     $from_path = $temp_file->path . '/' . $temp_file->filename;
                //     $to_path = 'public/employee-info/' . $update_employee_info->id . '/ex_certificate/' . $key . '/'  . $temp_file->filename;
                //     Storage::move($from_path, $to_path);
                //     Storage::deleteDirectory($temp_file->path);
                //     $update_employee_experience_info->ex_certificate = $to_path;
                // }


                //for ex_certificate
                if (isset($data['ec'])) {
                    $temp_file = TmpFile::findOrFail($data['ec']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/ex_certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_experience_info->ex_certificate = $to_path;
                }
                else {
                    $update_employee_experience_info->ex_certificate = $data['pre_ec'];
                }
                $update_employee_experience_info->save();
            }
        }


        // Employee Documents
        foreach ($request->document as $key => $data) {
            $update_employee_document_info = new employeeDocuments;
            $update_employee_document_info->employee_infos_id =  $update_employee_info->id;
            $update_employee_document_info->designation_id = $data['designation_id'];
            $update_employee_document_info->created_by = Auth::user()->id;
            $update_employee_document_info->created_at = Carbon::now()->toDateTimeString();
            $update_employee_document_info->save();

            //for NID or Birth Certificate
            if (isset($data['pre_nidordob_card'])) {
                if (isset($data['nidordob_card'])) {
                    $temp_file = TmpFile::findOrFail($data['nidordob_card']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/nid_or_dob/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->nid_or_dob = $to_path;
                } else {
                    $update_employee_document_info->nid_or_dob = $data['pre_nidordob_card'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['nidordob_card']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/nid_or_dob/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->nid_or_dob = $to_path;
            }
            //for CV
            if (isset($data['pre_cv'])) {
                if (isset($data['cv'])) {
                    $temp_file = TmpFile::findOrFail($data['cv']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/cv/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->cv = $to_path;
                } else {
                    $update_employee_document_info->cv = $data['pre_cv'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['cv']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/cv/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->cv = $to_path;
            }
            //for Character Certificate
            if (isset($data['pre_cc'])) {
                if (isset($data['cc'])) {
                    $temp_file = TmpFile::findOrFail($data['cc']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/character_certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->character_certificate = $to_path;
                } else {
                    $update_employee_document_info->character_certificate = $data['pre_cc'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['cc']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/character_certificate/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->character_certificate = $to_path;
            }

            $update_employee_document_info->save();
        }

        $this->message('success', "Employee Updated successfully");
        return redirect()->back();
    }


    public function delete($id)
    {
        // $this->check_access('delete subject-ssign');
        $delete = employeeInfos::where('deleted_at', null)->where('id', $id)->first();
        $delete->deleted_at = Carbon::now()->toDateTimeString();
        $delete->deleted_by = Auth::user()->id;
        $delete->save();
        $this->message('success', 'Pending Employee successfully deleted');
        // return redirect()->route('employee.new_employee.index');
        return redirect()->back();
    }


    // Employee Academic Info Download
    public function employee_reg_download($id)
    {
        $data = employeeAcademicInfos::findOrFail($id);

        if (Storage::exists($data->reg_card)) {
            $path = Storage::path($data->reg_card);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }
    public function employee_marksheet_download($id)
    {
        $data = employeeAcademicInfos::findOrFail($id);

        if (Storage::exists($data->marksheet)) {
            $path = Storage::path($data->marksheet);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }
    public function employee_certificate_download($id)
    {
        $data = employeeAcademicInfos::findOrFail($id);

        if (Storage::exists($data->certificate)) {
            $path = Storage::path($data->certificate);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }


    // Employee Experience Info Download
    public function employee_ex_certificate_download($id)
    {
        $data = employeeExperiences::findOrFail($id);

        if (Storage::exists($data->ex_certificate)) {
            $path = Storage::path($data->ex_certificate);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }


    // Employee Documents Download
    public function employee_nid_or_dob_download($id)
    {
        $data = employeeDocuments::findOrFail($id);

        if (Storage::exists($data->nid_or_dob)) {
            $path = Storage::path($data->nid_or_dob);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }
    public function employee_cv_download($id)
    {
        $data = employeeDocuments::findOrFail($id);

        if (Storage::exists($data->cv)) {
            $path = Storage::path($data->cv);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }
    public function employee_cc_download($id)
    {
        $data = employeeDocuments::findOrFail($id);

        if (Storage::exists($data->character_certificate)) {
            $path = Storage::path($data->character_certificate);
            return response()->download($path);
        }

        $this->message('error', 'File not found');
        return redirect()->back();
    }


    //Decline Employee

    public function decline_employee($id)
    {
        $data = employeeInfos::findOrFail($id);
        $data->status = -1;
        $data->save();

        $this->message('success', 'Employee ' . $data->name . ' Declined Successfully');
        return redirect()->route('employee.new_employee.index');
    }
    public function decline_list(Request $request)
    {
        $n['data'] = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'employeeAcademicInfo','employeeExperience', 'employeeDocument'])->where('deleted_at', null)->where('status', -1)->latest()->orderBy('departments_id')->get();
        $n['page_name'] = 'Declined Employees';

        return view('pages.employee.decline.show', $n);
    }
    public function decline_edit($id)
    {
        $n['page_name'] = 'Edit Pending Employee';
        $n['department'] = Department::where('deleted_by', '=', null)->get();
        $n['board'] = board::where('deleted_by', '=', null)->get();
        $n['exam_name'] = eadmission::where('deleted_by', '=', null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by', '=', null)->get();
        $n['designation'] = Designation::where('deleted_by', '=', null)->get();
        $n['division'] = Division::where('deleted_by', '=', null)->get();
        $n['district'] = District::where('deleted_by', '=', null)->get();
        $n['data'] = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'employeeAcademicInfo','employeeExperience', 'employeeDocument','department', 'bloodGroup', 'division', 'district'])->where('id', $id)->first();

        return view('pages.employee.decline.edit', $n);
    }
    public function decline_update(Request $request)
    {
        $rule = [
            'departments_id' => "required|exists:departments,id",

            // Employee Personal Data
            'name' => "required|string|max:255",
            'father_name' => "required|string|max:255",
            'mother_name' => "required|string|max:255",
            'present_address' => "required|string|max:1000",
            'parmanent_address' => "required|string|max:1000",
            'email' => "required|email|unique:employee_infos,email,$request->id,id,deleted_at,NULL",
            'phone' => "required|unique:employee_infos,phone,$request->id,id,deleted_at,NULL",
            'gender' => "required|string|max:255",
            'm_status'=> 'required|in:single,married',
            'spouse_name' => "nullable",
            'spouse_number' => "nullable",
            'dob' => "required|before:today",
            'nationality' => "required|string|max:255",
            'bg_id' => "required|exists:bloodgroups,id",
            'division_id' => "required|exists:divisions,id",
            'district_id' => "required|exists:districts,id",

            // Employee Academic Infos
            'exams.*.exam_id' => "required|exists:eadmissions,id",
            'exams.*.passing_year' => "required",
            'exams.*.group' => "required|string|max:255",
            'exams.*.board_id' => "required|exists:boards,id",
            'exams.*.gpa' => "required|numeric|between:0,5.00",

            // Employee Work Experience Data
            'experience.*.job_designation' => "string|max:255|nullable",
            'experience.*.company' => "string|max:255|nullable",
            'experience.*.start_month' => "nullable",
            'experience.*.end_month' => "nullable",

            // Employee Documents
            'document.*.designation_id' => "required|exists:designations,id"

        ];
        $msg = [];
        $attribute = [
            'departments_id' => 'Employee Department Name',

            // Employee Personal Data
            'name' => 'Employee Name',
            'father_name'  => 'Employee Father Name',
            'mother_name'  => 'Employee Mother Name',
            'present_address'  => 'Employee Present Address',
            'parmanent_address'  => 'Employee Permanent Address',
            'email'  => 'Employee Email',
            'phone'  => 'Employee Phone',
            'gender'  => 'Employee Gender',
            'm_status'=> 'Employee Marital Status',
            'dob'  => 'Employee Date of Birth',
            'nationality'  => 'Employee Nationality',
            'bg_id'  => 'Employee Blood Group',
            'division_id'  => 'Employee Division',
            'district_id'  => 'Employee District',

            // Employee Academic Infos
            'exams.*.exam_id'  => 'Employee Exam Name',
            'exams.*.passing_year'  => 'Employee Passing Year',
            'exams.*.group'  => 'Employee Group',
            'exams.*.board_id'  => 'Employee Board',
            'exams.*.roll'  => 'Employee Roll',
            'exams.*.reg_no'  => 'Employee Registration Number',
            'exams.*.gpa'  => 'Employee G.P.A',

            // Employee Work Experience Data
            'experience.*.job_designation' => 'Employee Job Designation',
            'experience.*.company' => 'Employee Company Name',
            'experience.*.start_month' => 'Employee Start Month',
            'experience.*.end_month' => 'Employee End Month',

            // Employee Documents
            'document.*.designation_id' => 'Employee New Designation',
        ];

        $this->validate($request, $rule, $msg, $attribute);

        foreach ($request->exams as $data) {
            if (!isset($data['pre_reg_card']) && !isset($data['reg_card'])) {
                $this->validate($request, ['exams.*.reg_card' => 'required'], [''], ['exams.*.reg_card'  => 'Employee Registration Card']);
            }
            if (!isset($data['pre_marksheet']) && !isset($data['marksheet'])) {
                $this->validate($request, ['exams.*.marksheet' => 'required'], [''], ['exams.*.marksheet'  => 'Employee Marksheet']);
            }
            if (!isset($data['pre_certificate']) && !isset($data['certificate'])) {
                $this->validate($request, ['exams.*.certificate' => 'required'], [''], ['exams.*.certificate'  => 'Employee Certificate']);
            }
        }
        employeeAcademicInfos::where('employee_infos_id', $request->id)->delete();

        // foreach ($request->experience as $data) {
        //     if (!isset($data['pre_ec']) && !isset($data['ec'])) {
        //         $this->validate($request, ['experience.*.ec' => 'required'], [''], ['experience.*.ec'  => 'Employee Experience Certificate']);
        //     }
        // }
        employeeExperiences::where('employee_infos_id', $request->id)->delete();

        foreach ($request->document as $data) {
            if (!isset($data['pre_nidordob_card']) && !isset($data['nidordob_card'])) {
                $this->validate($request, ['document.*.nidordob_card' => 'required'], [''], ['document.*.nidordob_card'  => 'Employee NID Card or Birth Certificate']);
            }
            if (!isset($data['pre_cv']) && !isset($data['cv'])) {
                $this->validate($request, ['document.*.cv' => 'required'], [''], ['document.*.cv'  => 'Employee CV']);
            }
            if (!isset($data['pre_cc']) && !isset($data['cc'])) {
                $this->validate($request, ['document.*.cc' => 'required'], [''], ['document.*.cc'  => 'Employee Character Certificate']);
            }
        }
        employeeDocuments::where('employee_infos_id', $request->id)->delete();

        $update_employee_info = employeeInfos::find($request->id);;
        $update_employee_info->departments_id = $request->departments_id;
        $update_employee_info->name = $request->name;
        $update_employee_info->father_name = $request->father_name;
        $update_employee_info->mother_name = $request->mother_name;
        $update_employee_info->present_address = $request->present_address;
        $update_employee_info->parmanent_address = $request->parmanent_address;
        $update_employee_info->email = $request->email;
        $update_employee_info->phone = $request->phone;

        $update_employee_info->gender = $request->gender;
        $update_employee_info->marital_status = $request->m_status;
        $update_employee_info->spouse_name = $request->spouse_name;
        $update_employee_info->spouse_number = $request->spouse_number;
        $update_employee_info->dob = $request->dob;
        $update_employee_info->nationality = $request->nationality;
        $update_employee_info->bg_id = $request->bg_id;

        $update_employee_info->division_id = $request->division_id;
        $update_employee_info->district_id = $request->district_id;
        $update_employee_info->created_by = Auth::user()->id;
        $update_employee_info->created_at = Carbon::now()->toDateTimeString();
        $update_employee_info->status = 0;
        $update_employee_info->save();

        //image upload
        if (isset($request->image)) {
            $temp_file = TmpFile::findOrFail($request->image);
            $from_path = $temp_file->path . '/' . $temp_file->filename;
            $to_path = 'public/employee-info/' . $update_employee_info->id . '/photo/' . $temp_file->filename;
            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);
            $update_employee_info->photo = $to_path;
        }
        else {
            $update_employee_info->photo = $request->pre_photo;
        }
        $update_employee_info->save();


        // Employee Academic Infos
        foreach ($request->exams as $key => $data) {
            $update_employee_academic_info = new employeeAcademicInfos;
            $update_employee_academic_info->employee_infos_id =  $update_employee_info->id;
            $update_employee_academic_info->exam_id = $data['exam_id'];
            $update_employee_academic_info->passing_year = $data['passing_year'];
            $update_employee_academic_info->group = $data['group'];
            $update_employee_academic_info->board_id = $data['board_id'];
            $update_employee_academic_info->roll = $data['roll'];
            $update_employee_academic_info->reg_no = $data['reg_no'];
            $update_employee_academic_info->gpa = $data['gpa'];
            $update_employee_academic_info->created_by = Auth::user()->id;
            $update_employee_academic_info->created_at = Carbon::now()->toDateTimeString();
            $update_employee_academic_info->save();
            //for reg
            if (isset($data['pre_reg_card'])) {
                if (isset($data['reg_card'])) {
                    $temp_file = TmpFile::findOrFail($data['reg_card']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/registration/' . $key . '/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->reg_card = $to_path;
                    } else {
                        $update_employee_academic_info->reg_card = $data['pre_reg_card'];
                    }
            } else {
                $temp_file = TmpFile::findOrFail($data['reg_card']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/registration/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->reg_card = $to_path;
            }
            //for marksheet
            if (isset($data['pre_marksheet'])) {
                if (isset($data['marksheet'])) {
                    $temp_file = TmpFile::findOrFail($data['marksheet']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/marksheet/' . $key . '/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->marksheet = $to_path;
                } else {
                    $update_employee_academic_info->marksheet = $data['pre_marksheet'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['marksheet']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/marksheet/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->marksheet = $to_path;
            }

            if (isset($data['pre_certificate'])) {
                if (isset($data['certificate'])) {
                    $temp_file = TmpFile::findOrFail($data['certificate']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->certificate = $to_path;
                } else {
                    $update_employee_academic_info->certificate = $data['pre_certificate'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['certificate']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/certificate/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->certificate = $to_path;
            }
            $update_employee_academic_info->save();
        }


        // Employee Work Experience Data
        if($request->experience){
            foreach ($request->experience as $key => $data) {
                $update_employee_experience_info = new employeeExperiences;
                $update_employee_experience_info->employee_infos_id =  $update_employee_info->id;
                $update_employee_experience_info->designation = $data['job_designation'];
                $update_employee_experience_info->company_name = $data['company'];
                $update_employee_experience_info->job_start = $data['start_month'];
                $update_employee_experience_info->job_end = $data['end_month'];
                $update_employee_experience_info->created_by = Auth::user()->id;
                $update_employee_experience_info->created_at = Carbon::now()->toDateTimeString();
                $update_employee_experience_info->save();

                //for ex_certificate
                if (isset($data['ec'])) {
                    $temp_file = TmpFile::findOrFail($data['ec']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/ex_certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_experience_info->ex_certificate = $to_path;
                }
                else {
                    $update_employee_experience_info->ex_certificate = $data['pre_ec'];
                }
                $update_employee_experience_info->save();
            }
        }


        // Employee Documents
        foreach ($request->document as $key => $data) {
            $update_employee_document_info = new employeeDocuments;
            $update_employee_document_info->employee_infos_id =  $update_employee_info->id;
            $update_employee_document_info->designation_id = $data['designation_id'];
            $update_employee_document_info->created_by = Auth::user()->id;
            $update_employee_document_info->created_at = Carbon::now()->toDateTimeString();
            $update_employee_document_info->save();

            //for NID or Birth Certificate
            if (isset($data['pre_nidordob_card'])) {
                if (isset($data['nidordob_card'])) {
                    $temp_file = TmpFile::findOrFail($data['nidordob_card']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/nid_or_dob/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->nid_or_dob = $to_path;
                } else {
                    $update_employee_document_info->nid_or_dob = $data['pre_nidordob_card'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['nidordob_card']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/nid_or_dob/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->nid_or_dob = $to_path;
            }
            //for CV
            if (isset($data['pre_cv'])) {
                if (isset($data['cv'])) {
                    $temp_file = TmpFile::findOrFail($data['cv']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/cv/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->cv = $to_path;
                } else {
                    $update_employee_document_info->cv = $data['pre_cv'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['cv']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/cv/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->cv = $to_path;
            }
            //for Character Certificate
            if (isset($data['pre_cc'])) {
                if (isset($data['cc'])) {
                    $temp_file = TmpFile::findOrFail($data['cc']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/character_certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->character_certificate = $to_path;
                } else {
                    $update_employee_document_info->character_certificate = $data['pre_cc'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['cc']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/character_certificate/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->character_certificate = $to_path;
            }

            $update_employee_document_info->save();
        }

        $this->message('success', "Declined Employee Updated successfully");
        return redirect()->back();
        // return redirect()->route('employee.new_employee.index');
    }

    public function decline_show($id)
    {
        $employee = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'department', 'bloodGroup', 'division', 'district', 'employeeAcademicInfo','employeeExperience', 'employeeDocument'])->where('deleted_at', null)->where('id', $id)->first();
        return view('pages.employee.decline.declinedinfo', ['employee' => $employee]);
    }


    //Accept Employee

    public function accept_employee($id)
    {
        $data = employeeInfos::findOrFail($id);
        $data->status = 1;
        $data->save();

        $this->message('success', 'Employee ' . $data->name . ' Accept Successfully');
        return redirect()->route('employee.new_employee.index');
    }
    public function accept_list(Request $request)
    {
        $n['data'] = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'employeeAcademicInfo','employeeExperience', 'employeeDocument'])->where('deleted_at', null)->where('status', 1)->latest()->orderBy('departments_id')->get();
        $n['page_name'] = 'Accept Employees';

        return view('pages.employee.accept.show', $n);
    }
    public function accept_edit($id)
    {
        $n['page_name'] = 'Edit Pending Employee';
        $n['department'] = Department::where('deleted_by', '=', null)->get();
        $n['board'] = board::where('deleted_by', '=', null)->get();
        $n['exam_name'] = eadmission::where('deleted_by', '=', null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by', '=', null)->get();
        $n['designation'] = Designation::where('deleted_by', '=', null)->get();
        $n['division'] = Division::where('deleted_by', '=', null)->get();
        $n['district'] = District::where('deleted_by', '=', null)->get();
        $n['data'] = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'employeeAcademicInfo','employeeExperience', 'employeeDocument','department', 'bloodGroup', 'division', 'district'])->where('id', $id)->first();

        return view('pages.employee.accept.edit', $n);
    }
    public function accept_update(Request $request)
    {
        $rule = [
            'departments_id' => "required|exists:departments,id",

            // Employee Personal Data
            'name' => "required|string|max:255",
            'father_name' => "required|string|max:255",
            'mother_name' => "required|string|max:255",
            'present_address' => "required|string|max:1000",
            'parmanent_address' => "required|string|max:1000",
            'email' => "required|email|unique:employee_infos,email,$request->id,id,deleted_at,NULL",
            'phone' => "required|unique:employee_infos,phone,$request->id,id,deleted_at,NULL",
            'gender' => "required|string|max:255",
            'm_status'=> 'required|in:single,married',
            'spouse_name' => "nullable",
            'spouse_number' => "nullable",
            'dob' => "required|before:today",
            'nationality' => "required|string|max:255",
            'bg_id' => "required|exists:bloodgroups,id",
            'division_id' => "required|exists:divisions,id",
            'district_id' => "required|exists:districts,id",

            // Employee Academic Infos
            'exams.*.exam_id' => "required|exists:eadmissions,id",
            'exams.*.passing_year' => "required",
            'exams.*.group' => "required|string|max:255",
            'exams.*.board_id' => "required|exists:boards,id",
            'exams.*.gpa' => "required|numeric|between:0,5.00",

            // Employee Work Experience Data
            'experience.*.job_designation' => "string|max:255|nullable",
            'experience.*.company' => "string|max:255|nullable",
            'experience.*.start_month' => "nullable",
            'experience.*.end_month' => "nullable",

            // Employee Documents
            'document.*.designation_id' => "required|exists:designations,id"

        ];
        $msg = [];
        $attribute = [
            'departments_id' => 'Employee Department Name',

            // Employee Personal Data
            'name' => 'Employee Name',
            'father_name'  => 'Employee Father Name',
            'mother_name'  => 'Employee Mother Name',
            'present_address'  => 'Employee Present Address',
            'parmanent_address'  => 'Employee Permanent Address',
            'email'  => 'Employee Email',
            'phone'  => 'Employee Phone',
            'gender'  => 'Employee Gender',
            'm_status'=> 'Employee Marital Status',
            'dob'  => 'Employee Date of Birth',
            'nationality'  => 'Employee Nationality',
            'bg_id'  => 'Employee Blood Group',
            'division_id'  => 'Employee Division',
            'district_id'  => 'Employee District',

            // Employee Academic Infos
            'exams.*.exam_id'  => 'Employee Exam Name',
            'exams.*.passing_year'  => 'Employee Passing Year',
            'exams.*.group'  => 'Employee Group',
            'exams.*.board_id'  => 'Employee Board',
            'exams.*.roll'  => 'Employee Roll',
            'exams.*.reg_no'  => 'Employee Registration Number',
            'exams.*.gpa'  => 'Employee G.P.A',

            // Employee Work Experience Data
            'experience.*.job_designation' => 'Employee Job Designation',
            'experience.*.company' => 'Employee Company Name',
            'experience.*.start_month' => 'Employee Start Month',
            'experience.*.end_month' => 'Employee End Month',

            // Employee Documents
            'document.*.designation_id' => 'Employee New Designation',
        ];

        $this->validate($request, $rule, $msg, $attribute);

        foreach ($request->exams as $data) {
            if (!isset($data['pre_reg_card']) && !isset($data['reg_card'])) {
                $this->validate($request, ['exams.*.reg_card' => 'required'], [''], ['exams.*.reg_card'  => 'Employee Registration Card']);
            }
            if (!isset($data['pre_marksheet']) && !isset($data['marksheet'])) {
                $this->validate($request, ['exams.*.marksheet' => 'required'], [''], ['exams.*.marksheet'  => 'Employee Marksheet']);
            }
            if (!isset($data['pre_certificate']) && !isset($data['certificate'])) {
                $this->validate($request, ['exams.*.certificate' => 'required'], [''], ['exams.*.certificate'  => 'Employee Certificate']);
            }
        }
        employeeAcademicInfos::where('employee_infos_id', $request->id)->delete();

        // foreach ($request->experience as $data) {
        //     if (!isset($data['pre_ec']) && !isset($data['ec'])) {
        //         $this->validate($request, ['experience.*.ec' => 'required'], [''], ['experience.*.ec'  => 'Employee Experience Certificate']);
        //     }
        // }
        employeeExperiences::where('employee_infos_id', $request->id)->delete();

        foreach ($request->document as $data) {
            if (!isset($data['pre_nidordob_card']) && !isset($data['nidordob_card'])) {
                $this->validate($request, ['document.*.nidordob_card' => 'required'], [''], ['document.*.nidordob_card'  => 'Employee NID Card or Birth Certificate']);
            }
            if (!isset($data['pre_cv']) && !isset($data['cv'])) {
                $this->validate($request, ['document.*.cv' => 'required'], [''], ['document.*.cv'  => 'Employee CV']);
            }
            if (!isset($data['pre_cc']) && !isset($data['cc'])) {
                $this->validate($request, ['document.*.cc' => 'required'], [''], ['document.*.cc'  => 'Employee Character Certificate']);
            }
        }
        employeeDocuments::where('employee_infos_id', $request->id)->delete();

        $update_employee_info = employeeInfos::find($request->id);;
        $update_employee_info->departments_id = $request->departments_id;
        $update_employee_info->name = $request->name;
        $update_employee_info->father_name = $request->father_name;
        $update_employee_info->mother_name = $request->mother_name;
        $update_employee_info->present_address = $request->present_address;
        $update_employee_info->parmanent_address = $request->parmanent_address;
        $update_employee_info->email = $request->email;
        $update_employee_info->phone = $request->phone;

        $update_employee_info->gender = $request->gender;
        $update_employee_info->marital_status = $request->m_status;
        $update_employee_info->spouse_name = $request->spouse_name;
        $update_employee_info->spouse_number = $request->spouse_number;
        $update_employee_info->dob = $request->dob;
        $update_employee_info->nationality = $request->nationality;
        $update_employee_info->bg_id = $request->bg_id;

        $update_employee_info->division_id = $request->division_id;
        $update_employee_info->district_id = $request->district_id;
        $update_employee_info->created_by = Auth::user()->id;
        $update_employee_info->created_at = Carbon::now()->toDateTimeString();
        $update_employee_info->save();

        //image upload
        if (isset($request->image)) {
            $temp_file = TmpFile::findOrFail($request->image);
            $from_path = $temp_file->path . '/' . $temp_file->filename;
            $to_path = 'public/employee-info/' . $update_employee_info->id . '/photo/' . $temp_file->filename;
            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);
            $update_employee_info->photo = $to_path;
        }
        else {
            $update_employee_info->photo = $request->pre_photo;
        }
        $update_employee_info->save();


        // Employee Academic Infos
        foreach ($request->exams as $key => $data) {
            $update_employee_academic_info = new employeeAcademicInfos;
            $update_employee_academic_info->employee_infos_id =  $update_employee_info->id;
            $update_employee_academic_info->exam_id = $data['exam_id'];
            $update_employee_academic_info->passing_year = $data['passing_year'];
            $update_employee_academic_info->group = $data['group'];
            $update_employee_academic_info->board_id = $data['board_id'];
            $update_employee_academic_info->roll = $data['roll'];
            $update_employee_academic_info->reg_no = $data['reg_no'];
            $update_employee_academic_info->gpa = $data['gpa'];
            $update_employee_academic_info->created_by = Auth::user()->id;
            $update_employee_academic_info->created_at = Carbon::now()->toDateTimeString();
            $update_employee_academic_info->save();
            //for reg
            if (isset($data['pre_reg_card'])) {
                if (isset($data['reg_card'])) {
                    $temp_file = TmpFile::findOrFail($data['reg_card']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/registration/' . $key . '/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->reg_card = $to_path;
                    } else {
                        $update_employee_academic_info->reg_card = $data['pre_reg_card'];
                    }
            } else {
                $temp_file = TmpFile::findOrFail($data['reg_card']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/registration/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->reg_card = $to_path;
            }
            //for marksheet
            if (isset($data['pre_marksheet'])) {
                if (isset($data['marksheet'])) {
                    $temp_file = TmpFile::findOrFail($data['marksheet']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/marksheet/' . $key . '/' . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->marksheet = $to_path;
                } else {
                    $update_employee_academic_info->marksheet = $data['pre_marksheet'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['marksheet']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/marksheet/' . $key . '/' . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->marksheet = $to_path;
            }

            //for certificate
            // if (isset($data['certificate'])) {
            //     $temp_file = TmpFile::findOrFail($data['certificate']);
            //     $from_path = $temp_file->path . '/' . $temp_file->filename;
            //     $to_path = 'public/employee-info/' . $update_employee_info->id . '/certificate/' . $key . '/'  . $temp_file->filename;
            //     Storage::move($from_path, $to_path);
            //     Storage::deleteDirectory($temp_file->path);
            //     $update_employee_academic_info->certificate = $to_path;
            // }
            // else {
            //     $update_employee_academic_info->certificate = $data['pre_certificate'];
            // }

            if (isset($data['pre_certificate'])) {
                if (isset($data['certificate'])) {
                    $temp_file = TmpFile::findOrFail($data['certificate']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_academic_info->certificate = $to_path;
                } else {
                    $update_employee_academic_info->certificate = $data['pre_certificate'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['certificate']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/certificate/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_academic_info->certificate = $to_path;
            }
            $update_employee_academic_info->save();
        }


        // Employee Work Experience Data
        if($request->experience){
            foreach ($request->experience as $key => $data) {
                $update_employee_experience_info = new employeeExperiences;
                $update_employee_experience_info->employee_infos_id =  $update_employee_info->id;
                $update_employee_experience_info->designation = $data['job_designation'];
                $update_employee_experience_info->company_name = $data['company'];
                $update_employee_experience_info->job_start = $data['start_month'];
                $update_employee_experience_info->job_end = $data['end_month'];
                $update_employee_experience_info->created_by = Auth::user()->id;
                $update_employee_experience_info->created_at = Carbon::now()->toDateTimeString();
                $update_employee_experience_info->save();

                //for experience Certificate
                // if (isset($data['pre_ec'])) {
                //     if (isset($data['ec'])) {
                //         $temp_file = TmpFile::findOrFail($data['ec']);
                //         $from_path = $temp_file->path . '/' . $temp_file->filename;
                //         $to_path = 'public/employee-info/' . $update_employee_info->id . '/ex_certificate/' . $key . '/'  . $temp_file->filename;
                //         Storage::move($from_path, $to_path);
                //         Storage::deleteDirectory($temp_file->path);
                //         $update_employee_experience_info->ex_certificate = $to_path;
                //     }else {
                //         $update_employee_experience_info->ex_certificate = $data['pre_ec'];
                //     }
                // } else {
                //     $temp_file = TmpFile::findOrFail($data['ec']);
                //     $from_path = $temp_file->path . '/' . $temp_file->filename;
                //     $to_path = 'public/employee-info/' . $update_employee_info->id . '/ex_certificate/' . $key . '/'  . $temp_file->filename;
                //     Storage::move($from_path, $to_path);
                //     Storage::deleteDirectory($temp_file->path);
                //     $update_employee_experience_info->ex_certificate = $to_path;
                // }


                //for ex_certificate
                if (isset($data['ec'])) {
                    $temp_file = TmpFile::findOrFail($data['ec']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/ex_certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_experience_info->ex_certificate = $to_path;
                }
                else {
                    $update_employee_experience_info->ex_certificate = $data['pre_ec'];
                }
                $update_employee_experience_info->save();
            }
        }


        // Employee Documents
        foreach ($request->document as $key => $data) {
            $update_employee_document_info = new employeeDocuments;
            $update_employee_document_info->employee_infos_id =  $update_employee_info->id;
            $update_employee_document_info->designation_id = $data['designation_id'];
            $update_employee_document_info->created_by = Auth::user()->id;
            $update_employee_document_info->created_at = Carbon::now()->toDateTimeString();
            $update_employee_document_info->save();

            //for NID or Birth Certificate
            if (isset($data['pre_nidordob_card'])) {
                if (isset($data['nidordob_card'])) {
                    $temp_file = TmpFile::findOrFail($data['nidordob_card']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/nid_or_dob/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->nid_or_dob = $to_path;
                } else {
                    $update_employee_document_info->nid_or_dob = $data['pre_nidordob_card'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['nidordob_card']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/nid_or_dob/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->nid_or_dob = $to_path;
            }
            //for CV
            if (isset($data['pre_cv'])) {
                if (isset($data['cv'])) {
                    $temp_file = TmpFile::findOrFail($data['cv']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/cv/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->cv = $to_path;
                } else {
                    $update_employee_document_info->cv = $data['pre_cv'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['cv']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/cv/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->cv = $to_path;
            }
            //for Character Certificate
            if (isset($data['pre_cc'])) {
                if (isset($data['cc'])) {
                    $temp_file = TmpFile::findOrFail($data['cc']);
                    $from_path = $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'public/employee-info/' . $update_employee_info->id . '/character_certificate/' . $key . '/'  . $temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_employee_document_info->character_certificate = $to_path;
                } else {
                    $update_employee_document_info->character_certificate = $data['pre_cc'];
                }
            } else {
                $temp_file = TmpFile::findOrFail($data['cc']);
                $from_path = $temp_file->path . '/' . $temp_file->filename;
                $to_path = 'public/employee-info/' . $update_employee_info->id . '/character_certificate/' . $key . '/'  . $temp_file->filename;
                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $update_employee_document_info->character_certificate = $to_path;
            }

            $update_employee_document_info->save();
        }

        $this->message('success', "Accept Employee Updated successfully");
        return redirect()->back();
    }

    public function accept_show($id)
    {
        $employee = employeeInfos::with(['created_user', 'updated_user', 'deleted_user', 'department', 'bloodGroup', 'division', 'district', 'employeeAcademicInfo','employeeExperience', 'employeeDocument'])->where('deleted_at', null)->where('id', $id)->first();
        return view('pages.employee.accept.acceptinfo', ['employee' => $employee]);
    }
}