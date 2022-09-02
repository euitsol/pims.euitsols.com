<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class n_subjectModel extends Model
{
    use HasFactory;
    protected $table = "subject_n";

    public function departments(){

        return $this->belongsTo(departmentModel::class,"departments_id");
        // return $this->belongsTo(User::class, 'foreign_key', 'other_key');
    }
}
