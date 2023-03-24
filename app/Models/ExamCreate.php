<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCreate extends Model
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
    public function search(){
        return $this->belongsTo(ExamSearch::class,'search_id', 'id');
    }
    public function type(){
        return $this->belongsTo(ExamType::class,'type_id', 'id');
    }

    public function schedules(){
        return $this->hasMany(ExamSchedule::class, 'create_id', 'id');
    }
    public function subject(){
        return $this->hasMany(ExamSubject::class, 'create_id', 'id');
    }
    public function hour_minute_type(){
        if($this->hour_minute == 1){
            return 'Hour';
        }elseif($this->hour_minute == 2){
            return 'Minute';
        }else{
            return '';
        }
    }
}
