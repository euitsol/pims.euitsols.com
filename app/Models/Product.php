<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updated_user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function deleted_user()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
    public function unit()
    {
        return $this->belongsTo(AssetUnit::class, 'unit_id');
    }

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'cat_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcat_id');
    }
    public function brand()
    {
        return $this->belongsTo(AssetBrand::class, 'brand_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function moreProduct()
    {
        return $this->hasMany(MoreProduct::class, 'product_id')->where('deleted_by',null);
    }

    public function departTotalProduct()
    {
        $total_product = Product::where('department_id', $this->department_id)->get();
        $available_product =  0;
        if (isset($total_product)) {
            foreach ($total_product as $product) {
                foreach ($product->moreProduct as $produts) {
                    $available_product += $produts->quantity;
                }
            }
        }
        return $available_product;
    }


    public function totalProduct()
    {
        $total_product = Product::find($this->id);
        $available_product =  0;
        if (isset($total_product)) {
            foreach ($total_product->moreProduct as $produt) {
                $available_product += $produt->quantity;
            }
        }
        return $available_product;
    }

    public function totalPrice()
    {
        $total_product = Product::find($this->id);
        $total_price =  0;
        if (isset($total_product)) {
            foreach ($total_product->moreProduct as $produt) {
                $total_price += $produt->total_price;
            }
        }
        return $total_price;
    }

    public function departAvailableProduct()
    {
        $total_product = Product::where('department_id', $this->department_id)->get();
        $available_product =  0;
        if (isset($total_product)) {
            foreach ($total_product as $product) {
                $available_product += $product->qty;
            }
        }
        return $available_product;
    }
    public function departmentName(){
        if($this->department_id){
          return  $this->department->department_name;
        }else{
            return "Common Asset";
        }
    }

    public function totalDamage(){
        $damages = AssetDamage::where('deleted_by')->where('product_id',$this->id)->get();
        $total_damage =  0;
        if (count($damages)>0) {
            foreach ($damages as $damage) {
                $total_damage += $damage->qty;
            }
        }
        return $total_damage;
    }
}
