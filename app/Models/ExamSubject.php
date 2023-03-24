<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model
{
    use HasFactory;

    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
    }
    public function create(){
        return $this->belongsTo(ExamCreate::class,'create_id', 'id');
    }
    public function exams(){
        $data = [];
        $exam_subjects = ExamSubject::where('subject_id', $this->id)->where('deleted_by',null)->latest()->get();
        foreach($exam_subjects as $key => $es){
            $data[$key] = $es->create;
        }
        return $data;
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
}
