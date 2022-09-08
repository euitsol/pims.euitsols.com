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
use Illuminate\Support\Facades\Auth;

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
       $insert_academic_info = new AcademicInfo;
       $insert_academic_info->exam_id = $request->exam_id;
       $insert_academic_info->passing_year = $request->passing_year;
       $insert_academic_info->division = $request->division;
       $insert_academic_info->roll = $request->roll;
       $insert_academic_info->reg_no = $request->reg_no;
       $insert_academic_info->gpa = $request->gpa;
       $insert_academic_info->reg_card = $request->reg_card;
       $insert_academic_info->marksheet = $request->marksheet;
       $insert_academic_info->created_by = Auth::user()->id;
       $insert_academic_info->save();

       $insert_student_info = new studentInfo;
       $insert_student_info->departments_id = $insert_student_info->id;
       $insert_student_info->academic_infos_id = $request->academic_infos_id;
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
       $insert_student_info->photo = $request->photo;
       $insert_student_info->session = $request->session;
       $insert_student_info->status = $request->status;
       $insert_student_info->created_by = Auth::user()->id;
       $insert_student_info->save();

        return redirect()->back()->with('msg','Successfully Inserted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
