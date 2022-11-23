<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignBookBkdn extends Model
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
    public function book(){
       return $this->BelongsTo(Book::class,'book_id');
    }

    public function bookAssign(){
        return $this->belongsTo(AssignBook::class,'assign_book_id');
    }
}
