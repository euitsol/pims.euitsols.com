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
}
