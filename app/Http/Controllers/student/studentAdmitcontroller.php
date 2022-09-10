<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\AcademicInfo;
use Illuminate\Http\Request;
use App\Models\AdmitStudent;
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

class studentAdmitcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $n['data'] = studentInfo::all();
        $n['page_name'] = 'Admit Student';
        $n['department'] = Department::where('deleted_by','=',null)->get();
        $n['board'] = board::where('deleted_by','=',null)->get();
        $n['exam_name'] = eadmission::where('deleted_by','=',null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by','=',null)->get();
        $n['division'] = Division::where('deleted_by','=',null)->get();
        return view('pages.student.admission.create',$n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // {{-- validation --}}
        // {{-- 'exams.*.exam_name' => 'required|exists:exams,id', --}}
        // {{-- controller --}}
        // {{-- foreach ($request->exams as $data) {
        // $data['exam_name']
        // $data['exam_name']
        // $data['exam_name']
        // $data['exam_name']
        // $data['exam_name']
        // $data['exam_name']
        // }
        // --}}

        // dd($request->all());

        // $attribute = array(
        //     'departments_id' => 'Department Name',
        //     'name' => 'Name',
        //     'father_name'  => 'Father Name',
        //     'mother_name'  => 'Mother Name',
        //     'present_address'  => 'Present Address',
        //     'parmanent_address'  => 'Permanent Address',
        //     'email'  => 'Email',
        //     'phone'  => 'Phone',
        //     'gardian_phone'  => 'Guardian Phone',
        //     'gender'  => 'Gender',
        //     'dob'  => 'Date of Birth',
        //     'nationality'  => 'Nationality',
        //     'bg_id'  => 'Blood Group',

        //     'exams.*.exam_id'  => 'Exam Name',
        //     'exams.*.passing_year'  => 'Passing Year',
        //     'exams.*.division'  => 'Divission',
        //     'exams.*.board_id'  => 'Board',
        //     'exams.*.roll'  => 'Roll',
        //     'exams.*.reg_no'  => 'Registration Number',
        //     'exams.*.gpa'  => 'G.P.A',
        //     'exams.*.reg_card'  => 'Registration Card',
        //     'exams.*.marksheet'  => 'Marsheet',
        // );
        // $request->validate([
        //     'departments_id' => "required|integer",
        //     'name' => "required|string",
        //     'father_name' => "required|string",
        //     'mother_name' => "required|string",
        //     'present_address' => "required|string",
        //     'parmanent_address' => "required|string",
        //     'email' => "nullable|email|unique:student_infos",
        //     'phone' => "required|unique:student_infos,phone",
        //     'gardian_phone' => "required",
        //     'gender' => "required",
        //     'dob' => "required",
        //     'nationality' => "required|string",
        //     'bg_id' => "nullable",
        //     'quota' => "nullable",
        //     // 'photo' => "required|mimes:jpg,jpg,png,svg,jpeg",

        //     'exams.*.exam_id' => "required",
        //     'exams.*.passing_year' => "required",
        //     'exams.*.division' => "required|string",
        //     'exams.*.board_id' => "required",
        //     'exams.*.roll' => "required|unique:academic_infos,roll|integer",
        //     'exams.*.reg_no' => "required|unique:academic_infos|integer",
        //     'exams.*.gpa' => "required",
        //     // 'exams.*.reg_card' => "required|mimes:jpg,png,pdf,svg,jpeg",
        //     // 'exams.*.marksheet' => "required|mimes:jpg,png,pdf,svg,jpeg",
        // ],[],$attribute);

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
        // $insert_student_info->photo = $request->photo;
        $insert_student_info->created_by = Auth::user()->id;
        $insert_student_info->save();



        //image upload
        $temp_file = TmpFile::findOrFail($request->image);
        if($temp_file){
            $from_path = $temp_file->path.'/'.$temp_file->filename;
            $to_path = 'student-info/'.$insert_student_info->id.'/photo/'.$temp_file->filename;

            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);

            $insert_student_info->photo = $to_path;
            $insert_student_info->save();
        }
        dd($insert_student_info);

        // dd($request->exams);
       foreach($request->exams as $data){
            $insert_academic_info = new AcademicInfo;
            $insert_academic_info->student_infos_id =  $insert_student_info->id;
            $insert_academic_info->exam_id = $data['exam_id'];
            $insert_academic_info->passing_year = $data['passing_year'];
            $insert_academic_info->division = $data['division'];
            $insert_academic_info->board_id = $data['board_id'];
            $insert_academic_info->roll = $data['roll'];
            $insert_academic_info->reg_no = $data['reg_no'];
            $insert_academic_info->gpa = $data['gpa'];
            $insert_academic_info->created_by = Auth::user()->id;
            // $insert_academic_info->save();


            //for reg
            $temp_file = TmpFile::findOrFail($data['reg_card']);
            if($temp_file){
                $from_path = $temp_file->path.'/'.$temp_file->filename;
                $to_path = 'student-info/'.$insert_student_info->id.'/registration/'.$temp_file->filename;

                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);

                $insert_academic_info->reg_card = $to_path;
            }

            //for marksheet
            $temp_file = TmpFile::findOrFail($data['marksheet']);
            if($temp_file){
                $from_path = $temp_file->path.'/'.$temp_file->filename;
                $to_path = 'student-info/'.$insert_student_info->id.'/marksheet/'.$temp_file->filename;

                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);

                $insert_academic_info->marksheet = $to_path;
            }

            $insert_academic_info->save();
       }

       $this->message('success',"Student admit successfully");
        // return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $n['data'] = studentInfo::where('deleted_by',null)->get();
        dd($n['data']);
        $n['page_name'] = 'Admitted Student';
        return view('pages.student.admission.show',$n);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax($id){
        $data = District::where('division_id',$id)->get();
        return response()->json($data);
    }
}
