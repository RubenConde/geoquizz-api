<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['description', 'latitude', 'longitude', 'url', 'idSeries'];

    public function series()
    {
        return $this->belongsTo(
            'App\Series',
            'idSeries');
    }
}
