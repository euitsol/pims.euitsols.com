<?php

namespace App\Models;

use App\Http\Controllers\student\StudentController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmittedStdAssign extends Model
{
    use HasFactory;
    public function studentInfo(){
        return $this->belongsTo(studentInfo::class,'student_infos_id');
    }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
    }
}
