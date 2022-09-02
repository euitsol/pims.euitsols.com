<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admissionModel;
use App\Models\studentInfo;
use App\Models\semester;
use App\User;
use App\Models\dsss_jt;
use App\Helpers\Qs;
use Illuminate\Support\Facades\Hash;

class admissionPromotController extends Controller
{
    public function Admission_std_show()
    {
       
        $d["promotion_list"] = admissionModel::where('status','=','wait for approved')->get();

        return view('pages.support_team.students.promotion.admissionPromossion', $d);
    }

    
     public function Admission_std_promotion(Request $request)
    {
        
    //    $id = Qs::decodeHash($id);
       $status = $request->status;
       $id = $request->id;
       $name = $request->name;
       $id = Qs::decodeHash($id);
       
       if($status == 'aprove'){
        $update = admissionModel::find($id);
        $update->status = 'Aproved';
        $update->save();

        $d['update']= $update;
        $d['id']= $id;
        $d['name']= $name;
        // $update->status = 'Aproved';
        // $update->save();
        // $randon_number = rand(1,999999);
        // $f_year = date('Y');
        // $year = substr($f_year,-2);
        // $user_id = $year-$randon_number;
        // $semester = semester::first();

        // $insert = new studentInfo;
        // $insert->user_id = $user_id;
        // $insert->name = $update->name;
        // $insert->father_name =  $update->father_name;
        // $insert->mother_name = $update->mother_name;
        // $insert->present_address = $update->present_address;
        // $insert->parmanent_address = $update->address;
        // $insert->email = $update->email;
        // $insert->gender = $update->gender;
        // $insert->phone =  $update->phone;
        // $insert->phone2 =  $update->phone2;
        // $insert->dob =  $update->dob;
        // $insert->Quota =  $update->Quota;
        // $insert->nationality =  $update->nationality;
        // $insert->blood_group_name = $update->blood_group_name;
        // $insert->exam_name =  $update->exam_name;
        // $insert->Department_name =  $update->Department_name;
        // $insert->semester_name = $semester->name;
        // $insert->registration_no =  $update->registration_no;
        // $insert->reg_card =  $update->reg_card;
        // $insert->marksheet =  $update->marksheet;
        // $insert->photo =  $update->photo;
        // $insert->status =  "not approved";

        
        return view('pages.support_team.students.promotion.assign', $d)->with('msg',"Successfully Aproved $name to Semester-1,See in Semester-1 student list. Now Assign Semester,group");
       }

       if($status == 'decline')
       {
        $update = admissionModel::find($id);
        $update->status = 'Declined';
        $update->save();
        return redirect()->back()->with("msg','Successfully Declined $name");
       }
        
        

        // return view('pages.support_team.students.promotion.admissionPromossion', $d);
    }
  public  function Admission_std_assign(Request $request)
  {
  
        $id = $request->id;
        $id = Qs::decodeHash($id);
        $department_id = Qs::decodeHash($request->department_id);
        $semester_id = Qs::decodeHash($request->semester_id);
        $section_id = Qs::decodeHash($request->section_id);
        $student_id =$request->student_id;

        // dd($department_id, $section_id, $semester_id);
        $session_start = $request->session_start;
        $session_end = $request->session_end;
        $session = $session_start . '-' . $session_end;
        
        $student_id_check = User::where('user_id', $student_id)->get();
        $count = count($student_id_check);
        
        if($count>0)
        {
            return redirect()->back()->with('msg',"$student_id. this ID is already taken.");
        }else{
                $update = admissionModel::find($id);
            
                //    rendom password create 
                function randomPassword() 
                {
                    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890+=_-)(*&^%$#@!~`{}[]|":;/>.<,'; //+=_-)(*&^%$#@!~`{}[]|":;/>.<,
                    $pass = array(); //remember to declare $pass as an array
                    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                    for ($i = 0; $i < 8; $i++) {
                        $n = rand(0, $alphaLength);
                        $pass[] = $alphabet[$n];
                    }
                    return implode($pass); //turn the array into a string
                }
                
                // dd(randomPassword());
                // Department Semester Student Section Junction Table Record Create 
                $insert_dsss_st = new dsss_jt;
                $insert_dsss_st->department_id = $department_id;
                $insert_dsss_st->semester_id = $semester_id;
                $insert_dsss_st->student_id = $student_id;
                $insert_dsss_st->section_id = $section_id;
                $insert_dsss_st->session = $session;
                $insert_dsss_st->save();
                
                // Student Information Store 
                $insert = new studentInfo;
                $insert->student_id = $student_id;
                $insert->name = $update->name;
                $insert->father_name =  $update->father_name;
                $insert->mother_name = $update->mother_name;
                $insert->present_address = $update->present_address;
                $insert->parmanent_address = $update->address;
                $insert->email = $update->email;
                $insert->gender = $update->gender;
                $insert->phone =  $update->phone;
                $insert->phone2 =  $update->phone2;
                $insert->dob =  $update->dob;
                $insert->Quota =  $update->Quota;
                $insert->nationality =  $update->nationality;
                $insert->blood_group_name = $update->blood_group_name;
                $insert->departments_id =  $department_id;
                $insert->registration_no =  $update->registration_no;
                $insert->reg_card =  $update->reg_card;
                $insert->marksheet =  $update->marksheet;
                $insert->photo =  $update->photo;
                $insert->save();
                
                // User Creation 
                $password = randomPassword();
                
                $insert_user = new User;
                $insert_user->name = $update->name;
                $insert_user->email = $update->email;
                $insert_user->user_table_id = $insert->id;
                $insert_user->user_id = $student_id;
                $insert_user->user_roll = 'student';
                $insert_user->password = Hash::make($password);
                $insert_user->save();
                return redirect()->route('students.Admission_std_show')->with('msg',"$update->name's ID= $student_id and Password = $password .You Have to remember this ");
            }
    }
    
}