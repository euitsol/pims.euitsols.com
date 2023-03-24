<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
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
    public function create(){
        return $this->belongsTo(ExamCreate::class,'create_id', 'id');
    }
    public function shift(){
        return $this->belongsTo(Shift::class,'shift_id', 'id');
    }
    public function group(){
        return $this->belongsTo(Group::class,'group_id', 'id');
    }
    public function exam_shift(){
        return $this->belongsTo(ExamShift::class,'exam_shift_id');
    }
}
