<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'images';

    protected $fillable = ['path', 'superhero_id'];

    public function superhero() {
        return $this->belongTo('App\Superhero');
    }
}
