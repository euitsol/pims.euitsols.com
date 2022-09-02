<?php

namespace App\Models;

use App\User;
use Eloquent;

class Section extends Eloquent
{
    protected $table = 'section';
    
    protected $fillable = ['name'];

}