<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdAttendance extends Model
{
    use HasFactory;

    public function attendance($attendance_id,$std_id){

        $class = $this->class;

        $check_attendance = StdAttendance::where('attendance_id',$attendance_id)
                            ->where('student_infos_id',$std_id)
                            ->where('class',$class)
                            ->where('attendance',1)
                            ->first();
        if($check_attendance==null){
            return true;
        }
        else{
            return false;
        }
    }


}
