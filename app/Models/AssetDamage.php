<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDamage extends Model
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

    public function mainAssign(){
        return $this->belongsTo(MainAssignProduct::class,'main_assign_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
