<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;
    public function created_user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updated_user(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function deleted_user(){
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
    public function session(){
        return $this->belongsTo(Session::class,'session_id');
     }
    public function department(){
        return $this->belongsTo(Department::class,'departments_id');
     }
    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
     }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
     }
    public function group(){
        return $this->belongsTo(Group::class,'group_id');
     }
    public function shift(){
        return $this->belongsTo(Shift::class,'shift_id');
     }
    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id');
     }
     public function getDate($class){
        $attendace_id = $this->id;

        $get_data = StdAttendance::where('attendance_id',$attendace_id)
                ->where('class',$class)
                ->first();
        return $get_data;
    }
     public function countStd($semester_id){

        $students = AdmittedStdAssign::where('semester_id',$semester_id)
                ->where('deleted_at',null)
                ->get();
        $student_count = count($students);
        return $student_count;
    }

     public function countPresentStd($class){
        $attendace_id = $this->id;
        $present_students = StdAttendance::where('attendance_id',$attendace_id)
                    ->where('class',$class)
                    ->where('attendance',1)
                    ->get();
        $present_students = count($present_students);
        return $present_students;
    }

    public function classContentCheck($class){
       $attendace_id =  $this->id;
       $std_attendance = StdAttendance::where('attendance_id',$attendace_id)->where('class',$class)->first();

       if(isset($std_attendance->id)){

           $class_content = ClassContent::where('std_attendance_id',$std_attendance->id)->first();
           if($class_content==null){
            return false;
           }else{
            return true;
           }
       }else{
        return false;
       }
    }

    public function attendanceCheck($class){
        $check = StdAttendance::where('attendance_id',$this->id)->where('class',$class)->first();
        if($check){
            return true;
        }else{
            return false;
        }
    }

    public function totalStudent(){
        $students = AdmittedStdAssign::where('deleted_by',null)->get();
        if($students){
            return count($students);
        }else{
            return 0;
        }
    }
}
