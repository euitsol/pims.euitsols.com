<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignProduct extends Model
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
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }
    public function section(){
        return $this->belongsTo(Section::class,'section_id');
    }
    public function subsection(){
        return $this->belongsTo(Subsection::class,'subsection_id');
    }
    public function mainProduct(){
        return $this->hasMany(MainAssignProduct::class,'assign_product_id')->where('deleted_by',null);
    }
    public function totalAssignedProduct(){
        $total_product = MainAssignProduct::where('deleted_by',null)->get();
        $total_qty =  0;
        foreach($total_product as $product){
            $total_qty += $product->qty;
        }
        return $total_qty;
    }
    public function departAssignedProduct(){
        $total_product = MainAssignProduct::where('assign_product_id',$this->id)->get();
        $total_qty =  0;
        foreach($total_product as $product){
            $total_qty += $product->qty;
        }
        return $total_qty;
    }

    public function departmentName(){

        if($this->department_id){
            return  $this->department->department_name;
          }else{
              return "Common Asset";
          }
    }
}
