<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class employeeDocuments extends Model
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
    public function designation(){
        return $this->BelongsTo(Designation::class,'designation_id', 'id');
    }

    public function EmployeeInfo(){
        return $this->BelongsTo(employeeInfos::class,'employee_infos_id');
    }
}
