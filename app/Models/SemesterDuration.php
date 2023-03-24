<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterDuration extends Model
{
    use HasFactory;

    public function semester(){
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
    public function session(){
        return $this->belongsTo(Session::class, 'session_id', 'id');
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
