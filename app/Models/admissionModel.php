<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class admissionModel extends Model
{
    use HasFactory;
    protected $table = "admission_info";
    protected $fillable = ["name","father_name","mother_name","present_address","address","email","gender","phone","phone2","dob","Quota","nationality","blood_group_name","exam_name","passing_year","division","board","roll","registration_no","gpa","reg_card","marksheet","photo","updated_at","created_at"];
    
    public function departments(){
        return $this->BelongsTo(departmentModel::class,'departments_id');
    }
}
