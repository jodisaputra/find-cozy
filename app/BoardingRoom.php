<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardingRoom extends Model
{
    protected $table = 'boarding_rooms';

    protected $fillable = [
        'boarding_house_id',
        'name',
        'status',
        'price',
    ];

}
