<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAssign extends Model
{
    use HasFactory;
    protected $fillable = ['session_id','department_id','subject_id','semester_id','created_by','updated_by','deleted_by','deleted_at'];

    public function session(){
        return $this->belongsTo(Session::class,'session_id');
     }
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
     }
    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
     }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
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

    public function teacherAssign(){
        return $this->hasMany(TeacherAssign::class, 'subject_assign_id');
    }
}
