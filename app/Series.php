<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = ['city', 'latitude', 'longitude', 'zoom'];

    public function photos()
    {
        return $this->hasMany(
            'App\Photo',
            'idSeries',
            'id'
        );
    }

    public function games()
    {
        return $this->hasMany(
            'App\Game',
            'idSeries',
            'id'
        );
    }
}
