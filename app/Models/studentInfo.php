<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentInfo extends Model
{
    use HasFactory;
    public function department(){

        return $this->belongsTo(Department::class,'departments_id');
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

    public function academicInfo(){
        return $this->hasMany(AcademicInfo::class, 'student_infos_id');
    }


}
