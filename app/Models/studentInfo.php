<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentInfo extends Model
{
    use HasFactory;
    public function Department(){

        return $this->belongsTo(Department::class,'departments_id');
    }
    public function AcademicInfo(){

        return $this->belongsTo(Department::class,'departments_id');
    }
}
