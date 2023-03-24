<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeeInfos extends Model
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
    public function bloodGroup(){
        return $this->belongsTo(Bloodgroup::class, 'bg_id', 'id');
    }
    public function division(){
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }
    public function district(){
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function employeeAcademicInfo(){
        return $this->hasMany(employeeAcademicInfos::class, 'employee_infos_id');
    }
    public function employeeExperience(){
        return $this->hasMany(employeeExperiences::class, 'employee_infos_id');
    }
    public function employeeDocument(){
        return $this->hasMany(employeeDocuments::class, 'employee_infos_id');
    }
}
