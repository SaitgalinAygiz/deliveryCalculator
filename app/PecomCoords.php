<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PecomCoords extends Model
{
    protected $fillable = [
        'address_latitude',
        'address_longitude'
    ];

    public function coords()
    {
        return $this->belongsToMany('App\PecomCity');
    }
}
