<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
    }
    public function session(){
        return $this->belongsTo(Session::class,'session_id');
    }
    public function group(){
        return $this->belongsTo(Group::class,'group_id');
    }
    public function shift(){
        return $this->belongsTo(Shift::class,'shift_id');
    }
    public function dates(){
        return $this->hasMany(RoutineDates::class, 'routine_id');
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

    public function get_subjects(){
        $subjects = SubjectAssign::with(['subject'])->where('session_id', $this->session_id)->where('department_id', $this->department_id)->where('semester_id', $this->semester_id)->where('deleted_at', null)->latest()->get();
        return $subjects;
    }
}
