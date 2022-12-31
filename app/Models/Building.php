<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
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


    public function floor(){

        return  $this->hasMany(Floor::class,'building_id');
    }
    public function total_room(){
        $floors = Floor::where('building_id',$this->id)->get();
        $total_room = 0;
        foreach($floors as $floor){
             $total_room += count(Room::where('floor_id',$floor->id)->get());
        }
        return $total_room;
    }

    public function total_seat(){
        $floors = Floor::where('building_id',$this->id)->get();
        $total_seat = 0;
        foreach($floors as $floor){
            $rooms = Room::where('floor_id',$floor->id)->get();
            foreach($rooms as $room)
             $total_seat += $room->total_seat;
        }
        return $total_seat;
    }

}
