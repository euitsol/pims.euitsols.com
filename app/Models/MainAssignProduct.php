<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainAssignProduct extends Model
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
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'cat_id');
    }
    public function subcategory(){
        return $this->belongsTo(Subcategory::class,'subcat_id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function assignProduct(){
        return $this->belongsTo(AssignProduct::class,'assign_product_id');
    }
    public function damage(){
        return $this->hasMany(AssetDamage::class,'main_assign_id')->where('deleted_by',null)->first();
    }
    public function damageQty(){
        $qty = 0;
        foreach($this->damage as $damage){
            $qty += $damage->qty;
        }
        return $qty;
    }
    public function totalDamage(){
        $qty = 0;
        foreach($this->damage as $damage){
            $qty += $damage->qty;
        }
        return $qty;
    }

}
