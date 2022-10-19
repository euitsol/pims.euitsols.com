<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutineDates extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id ',
        'routine_id',
        'day',
        'start',
        'end'
    ];
}
