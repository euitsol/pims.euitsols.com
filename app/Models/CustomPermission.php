<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class CustomPermission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

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
