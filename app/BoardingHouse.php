<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardingHouse extends Model
{
    protected $table = 'boarding_houses';

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'map_url',
        'city'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
