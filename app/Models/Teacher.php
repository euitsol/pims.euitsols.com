<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
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
    public function department(){
        return $this->belongsTo(Department::class, 'departments_id', 'id');
    }
    public function division(){
        return $this->belongsTo(Division::class, 'divisions_id', 'id');
    }
    public function district(){
        return $this->belongsTo(District::class, 'districts_id', 'id');
    }
    public function bloodgroup(){
        return $this->belongsTo(Bloodgroup::class, 'bloodgroups_id', 'id');
    }
    public function teacherCheck(){
        if(LibraryMember::where('teacher_id',$this->id)->first()){
            return true;
        }else{
            return false;
        }
    }
}
