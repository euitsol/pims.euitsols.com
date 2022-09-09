<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicInfo extends Model
{
    use HasFactory;


    public function departments(){
        return $this->BelongsTo(departmentModel::class,'departments_id');
    }
}
