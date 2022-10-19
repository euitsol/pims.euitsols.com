<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubjectAssign;
use Carbon\Carbon;

class Subject extends Model
{
    use HasFactory;

    public function credit(){
        return $this->belongsTo(Credit::class, 'credit_id', 'id');
    }
    public function department(){
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }


    public function created_user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updated_user(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function deleted_user(){
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function subjectIsAssign($session_id,$semester_id,$department_id){
        $subject_id = $this->id;
        $check = SubjectAssign::where('session_id',$session_id)->where('department_id',$department_id)->where('subject_id',$subject_id)->where('deleted_at', null)->get()->count();
        if($check>0){
            return true;
        }else{
            return false;
        }
    }

    public function duration(){
        $duration = '';
        if($this->credit->hour_minute == 1){
            $duration = $this->credit->class_hour * 60;
        }else{
            $duration = $this->credit->class_hour;
        }
        $duration = floor($duration / 60).':'.($duration - floor($duration / 60) * 60);
        return $duration;
    }
}
