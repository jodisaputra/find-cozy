<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardingHouseImage extends Model
{
    protected $table = 'boarding_house_images';

    protected $fillable = [
        'boarding_house_id',
        'image'
    ];
}
