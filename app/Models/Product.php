<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
    public function unit(){
        return $this->belongsTo(AssetUnit::class,'unit_id');
    }

    public function category(){
        return $this->belongsTo(AssetCategory::class,'cat_id');
    }
    public function subcategory(){
        return $this->belongsTo(Subcategory::class,'subcat_id');
    }
    public function brand(){
        return $this->belongsTo(AssetBrand::class,'brand_id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
}
