<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignBook extends Model
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

    public function student(){
       return $this->BelongsTo(LibraryMember::class,'std_id');
    }
    public function book(){
        return $this->belongsTo(Book::class,'book_id');
    }
    public function status(){
        if($this->status == '0'){
            return "Assigned";
        }elseif($this->status == '1'){
            return "Returned";
        }else{
            return 'Delay';
        }
    }
}
