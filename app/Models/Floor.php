<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
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

    public function building(){
        return $this->belongsTo(Building::class,'building_id','id');
    }
    public function rooms(){
            $rooms = Room::where('floor_id',$this->id)->get();
            if($rooms){
                return $rooms;
            }else{
                return [];
            }
    }

    public function room(){
       return $this->hasMany(Room::class,'floor_id');
    }


}
