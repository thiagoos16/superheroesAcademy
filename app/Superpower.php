<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Superpower extends Model
{
    protected $table = 'superpower';

    protected $fillable = ['name'];
}
