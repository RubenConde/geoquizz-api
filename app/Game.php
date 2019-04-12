<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['status', 'score', 'player', 'idSeries', 'idDifficulty'];

    public function series()
    {
        return $this->belongsTo(
            'App\Series',
            'idSeries');
    }

    public function difficulty()
    {
        return $this->belongsTo(
            'App\Difficulty',
            'idDifficulty');
    }
}
