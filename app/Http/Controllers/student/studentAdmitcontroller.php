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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $n['data'] = studentInfo::with(['created_user', 'updated_user', 'deleted_user','academicInfo'])->where('deleted_at', null)->where('status', 0)->latest()->get();
        // dd($n['data']);
        $n['page_name'] = 'Admitted Student';

       return view('pages.student.admission.show',$n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'departments_id' => "required|integer",
            'name' => "required|string",
            'father_name' => "required|string",
            'mother_name' => "required|string",
            'present_address' => "required|string",
            'parmanent_address' => "required|string",
            'email' => "nullable|email|unique:student_infos,email",
            'phone' => "required|unique:student_infos,phone",
            'gardian_phone' => "required",
            'gender' => "required",
            'dob' => "required",
            'nationality' => "required|string",
            'bg_id' => "nullable|exists:bloodgroups,id",
            'quota' => "nullable",
            'division_id' => "required",
            'district_id' => "required",
            'photo' => "nullable",

            'exams.*.exam_id' => "required",
            'exams.*.passing_year' => "required",
            'exams.*.division' => "required",
            'exams.*.board_id' => "required",
            'exams.*.roll' => "required",
            'exams.*.reg_no' => "required|unique:academic_infos,reg_no",
            'exams.*.gpa' => "required",
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
            'division'  => 'Division',
            'district'  => 'District',

            'exams.*.exam_id'  => 'Exam Name',
            'exams.*.passing_year'  => 'Passing Year',
            'exams.*.division'  => 'Divission',
            'exams.*.board_id'  => 'Board',
            'exams.*.roll'  => 'Roll',
            'exams.*.reg_no'  => 'Registration Number',
            'exams.*.gpa'  => 'G.P.A',
            'exams.*.reg_card'  => 'Registration Card',
            'exams.*.marksheet'  => 'Marksheet'
        ];
        // $request->validate($rule);
        $this->validate($request,$rule,$msg,$attribute);
        // $this->validate($request, [
        //     'exams.*.exam_id' => "required",
        //     'exams.*.passing_year' => "required",
        //     'exams.*.group' => "required|string",
        //     'exams.*.board_id' => "required",
        //     'exams.*.roll' => "required|unique:academic_infos,roll|integer",
        //     'exams.*.reg_no' => "required|unique:academic_infos,reg_no|integer",
        //     'exams.*.gpa' => "required"
        // ]);
        // Validator::make($request->all(),$rule,[],$attribute);

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
        $insert_student_info->save();

        //image upload
        $temp_file = TmpFile::findOrFail($request->image);
        if($temp_file){
            $from_path = $temp_file->path.'/'.$temp_file->filename;
            $to_path = 'public/student-info/'.$insert_student_info->id.'/photo/'.$temp_file->filename;

            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);

            $insert_student_info->photo = $to_path;
            $insert_student_info->save();
        }

       foreach($request->exams as $data){
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
            // $insert_academic_info->save();


            //for reg
            $temp_file = TmpFile::findOrFail($data['reg_card']);
            if($temp_file){
                $from_path = $temp_file->path.'/'.$temp_file->filename;
                $to_path = 'public/student-info/'.$insert_student_info->id.'/registration/'.$temp_file->filename;

                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                $insert_academic_info->reg_card = $to_path;
            }

            //for marksheet
            $temp_file = TmpFile::findOrFail($data['marksheet']);
            if($temp_file){
                $from_path = $temp_file->path.'/'.$temp_file->filename;
                $to_path = 'public/student-info/'.$insert_student_info->id.'/marksheet/'.$temp_file->filename;

                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);

                $insert_academic_info->marksheet = $to_path;
            }

            $insert_academic_info->save();
       }

       $this->message('success',"Student admit successfully");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = studentInfo::with(['created_user', 'updated_user', 'deleted_user', 'department', 'bloodGroup', 'division', 'district', 'academicInfo'])->where('deleted_at', null)->where('id', $id)->first();
        // dd($student);
        return view('pages.student.admission.registration',[ 'student' => $student ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $n['page_name'] = 'Edit Pending Student';
        $n['department'] = Department::where('deleted_by','=',null)->get();
        $n['board'] = board::where('deleted_by','=',null)->get();
        $n['exam_name'] = eadmission::where('deleted_by','=',null)->get();
        $n['bg'] = Bloodgroup::where('deleted_by','=',null)->get();
        $n['division'] = Division::where('deleted_by','=',null)->get();
        $n['district'] = District::where('deleted_by','=',null)->get();
        $n['data'] = studentInfo::with(['created_user', 'updated_user', 'deleted_user','academicInfo','department','bloodGroup','division','district'])->where('id',$id)->first();
        return view('pages.student.admission.edit',$n);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rule = [
            'departments_id' => "required|integer",
            'name' => "required|string",
            'father_name' => "required|string",
            'mother_name' => "required|string",
            'present_address' => "required|string",
            'parmanent_address' => "required|string",
            'email' => "nullable|email|unique:student_infos,email,".$request->id,
            'phone' => "required|unique:student_infos,phone,".$request->id,
            'gardian_phone' => "required",
            'gender' => "required",
            'dob' => "required",
            'nationality' => "required|string",
            'bg_id' => "nullable|exists:bloodgroups,id",
            'quota' => "nullable",
            'division_id' => "required",
            'district_id' => "required",
            // 'photo' => "required",
            'exams.*.exam_id' => "required",
            'exams.*.passing_year' => "required",
            'exams.*.group' => "required",
            'exams.*.board_id' => "required",
            'exams.*.roll' => "required",
            'exams.*.reg_no' => "required|unique:academic_infos,reg_no",
            'exams.*.gpa' => "required",
            // 'exams.*.reg_card' => "required",
            // 'exams.*.marksheet' => "required",
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
            // 'exams.*.reg_card'  => 'Registration Card',
            // 'exams.*.marksheet'  => 'Marksheet'
        ];
        $this->validate($request,$rule,$msg,$attribute);

        $i =0;
        foreach($request->exams as $data){
            // dd();
            if(!isset($data['pre_reg_card'])){
                    $this->validate($request,['exams['.$i.']["reg_card"]' => 'required']);
            }
            if(!isset($data['pre_marksheet'])){
                    $this->validate($request,['exams['.$i.']["marksheet"]' => 'required']);
            }
            $i = $i+1;

        }

 dd($request->exams);

        AcademicInfo::where('student_infos_id',$request->id)->delete();
        $update_student_info =studentInfo::find($request->id);
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
        // $update_student_info->status = 0;
        $update_student_info->created_by = Auth::user()->id;
        $update_student_info->save();

        // image upload
        if(isset($request->image)){
            $temp_file = TmpFile::findOrFail($request->image);
            $from_path = $temp_file->path.'/'.$temp_file->filename;
            $to_path = 'public/student-info/'.$update_student_info->id.'/photo/'.$temp_file->filename;
            Storage::move($from_path, $to_path);
            Storage::deleteDirectory($temp_file->path);
            $update_student_info->photo = $to_path;
        }else{
            $update_student_info->photo = $request->pre_photo;
        }
        $update_student_info->save();

       foreach($request->exams as $data){
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
            $update_academic_info->save();

            //for reg
            if(isset($data['pre_reg_card'])){
                if(isset($data['reg_card'])){
                    $temp_file = TmpFile::findOrFail($data['reg_card']);
                    $from_path = $temp_file->path.'/'.$temp_file->filename;
                    $to_path = 'public/student-info/'.$update_student_info->id.'/registration/'.$temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->reg_card = $to_path;
                }else{
                    $update_academic_info->reg_card = $data['pre_reg_card'];
                }
            }else{
                    $temp_file = TmpFile::findOrFail($data['reg_card']);
                    $from_path = $temp_file->path.'/'.$temp_file->filename;
                    $to_path = 'public/student-info/'.$update_student_info->id.'/registration/'.$temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->reg_card = $to_path;
            }
            if(isset($data['pre_marksheet'])){
                if(isset($data['marksheet'])){
                    $temp_file = TmpFile::findOrFail($data['marksheet']);
                    $from_path = $temp_file->path.'/'.$temp_file->filename;
                    $to_path = 'public/student-info/'.$update_student_info->id.'/marksheet/'.$temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->marksheet = $to_path;
                }else{
                    $update_academic_info->marksheet = $data['pre_marksheet'];
                }
            }else{
                    $temp_file = TmpFile::findOrFail($data['marksheet']);
                    $from_path = $temp_file->path.'/'.$temp_file->filename;
                    $to_path = 'public/student-info/'.$update_student_info->id.'/marksheet/'.$temp_file->filename;
                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->marksheet = $to_path;
            }
            $update_academic_info->save();
       }
        $this->message('success',"Student admit successfully");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // echo 'ok';
        // $this->check_access('admission delete');
        // if($id != null){
        //     $student_info = studentInfo::findOrFail($id);
        //     $student_info->deleted_at = Carbon::now()->toDateTimeString();
        //     $student_info->deleted_by = auth()->user()->id;
        //     $student_info->save();
        //     $this->message('success', 'Admitted Student "'.$student_info->name.'" deleted successfully');
        //     return redirect()->route('student-admit.index');
        // }
    }


    public function ajax($id){
        $data = District::where('division_id',$id)->get();
        return response()->json($data);
    }

    public function delete($id){
        $this->check_access('admission delete');
        if($id != null){
            $student_info = studentInfo::findOrFail($id);
            $student_info->deleted_at = Carbon::now()->toDateTimeString();
            $student_info->deleted_by = auth()->user()->id;
            $student_info->save();
            $this->message('success', 'Admitted Student "'.$student_info->name.'" deleted successfully');
            return redirect()->route('student-admit.index');
        }
    }

    public function pendingStdUpdate(Request $request){
        // dd($request->all());
        // AcademicInfo::where('student_infos_id',$id)->delete();
        //  studentInfo::find($id)->delete();

        $update_student_info =new studentInfo;
        // $update_student_info->departments_id = $request->departments_id;
        // $update_student_info->name = $request->name;
        // $update_student_info->father_name = $request->father_name;
        // $update_student_info->mother_name = $request->mother_name;
        // $update_student_info->present_address = $request->present_address;
        // $update_student_info->parmanent_address = $request->parmanent_address;
        // $update_student_info->email = $request->email;
        // $update_student_info->phone = $request->phone;
        // $update_student_info->gardian_phone = $request->gardian_phone;
        // $update_student_info->gender = $request->gender;
        // $update_student_info->dob = $request->dob;
        // $update_student_info->nationality = $request->nationality;
        // $update_student_info->bg_id = $request->bg_id;
        // $update_student_info->quota = $request->quota;
        // $update_student_info->division_id = $request->division_id;
        // $update_student_info->district_id = $request->district_id;
        // $update_student_info->created_by = Auth::user()->id;
        // $update_student_info->save();

        // image upload
        // dd($request->all());

            $temp_file = TmpFile::findOrFail($request->image);
            if($temp_file){
                $from_path = $temp_file->path.'/'.$temp_file->filename;
                $to_path = 'public/student-info/'.$update_student_info->id.'/photo/'.$temp_file->filename;

                Storage::move($from_path, $to_path);
                Storage::deleteDirectory($temp_file->path);
                dd('your photo'.$to_path);
                $update_student_info->photo = $to_path;
                // $update_student_info->save();
            }else{
                $update_student_info->photo = $request->pre_photo;
                echo 'your previous photo';
                dd($request->pre_photo);
            }



       foreach($request->exams as $data){
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
            $update_academic_info->save();

            //for reg
            if(isset($data['pre_reg_card'])){
                $temp_file = TmpFile::findOrFail($data['reg_card']);

                if($temp_file){
                    $from_path = $temp_file->path.'/'.$temp_file->filename;
                    $to_path = 'public/student-info/'.$update_student_info->id.'/registration/'.$temp_file->filename;

                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->reg_card = $to_path;
                }else{
                    // $academic_info = AcademicInfo::find();
                    $update_academic_info->reg_card = $data['pre_reg_card'];
                }
            }



            //for marksheet
            // $temp_file = TmpFile::findOrFail($data['marksheet']);
            // if($temp_file){
            //     $from_path = $temp_file->path.'/'.$temp_file->filename;
            //     $to_path = 'public/student-info/'.$update_student_info->id.'/marksheet/'.$temp_file->filename;

            //     Storage::move($from_path, $to_path);
            //     Storage::deleteDirectory($temp_file->path);

            //     $update_academic_info->marksheet = $to_path;
            // }
            if(isset($data['pre_marksheet'])){
                $temp_file = TmpFile::findOrFail($data['pre_marksheet']);

                if($temp_file){
                    $from_path = $temp_file->path.'/'.$temp_file->filename;
                    $to_path = 'public/student-info/'.$update_student_info->id.'/marksheet/'.$temp_file->filename;

                    Storage::move($from_path, $to_path);
                    Storage::deleteDirectory($temp_file->path);
                    $update_academic_info->marksheet = $to_path;
                }else{
                    $update_academic_info->marksheet = $data['pre_marksheet'];
                }
            }

            $update_academic_info->save();
       }

        //   Delete Information

       $this->message('success',"Student admit successfully");
        return redirect()->back();
    }
}
