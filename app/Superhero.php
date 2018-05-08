<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Superhero extends Model
{
    protected $table = 'superhero';

    protected $fillable = ['nickname', 'real_name', 'origin_description', 'catch_phrase'];

    public function superpowers() {
        return $this->belongsToMany('App\Superpower')->withTimestamps();
    }
}
