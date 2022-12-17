<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'department_id',
        'semester_id',
        'created_by',
        'created_at',
    ];

    public function created_user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updated_user(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function deleted_user(){
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
    public function session(){
        return $this->belongsTo(Session::class,'session_id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
    }
}
