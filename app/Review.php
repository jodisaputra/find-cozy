<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'boarding_house_id',
        'created_by',
        'rate',
        'comment'
    ];

}
