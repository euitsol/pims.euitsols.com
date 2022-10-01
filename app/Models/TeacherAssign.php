<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAssign extends Model
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
    public function subjectAssign(){
        return $this->belongsTo(SubjectAssign::class,'subject_assign_id');
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
   
}
