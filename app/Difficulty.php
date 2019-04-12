<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Difficulty extends Model
{
    protected $fillable = ['name', 'distance', 'numberOfPhotos'];

    public function games()
    {
        return $this->hasMany(
            'App\Game',
            'idDifficulty',
            'id'
        );
    }
}
