<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zapatos extends Model
{
    protected $fillable = [
        'name',
        'description',
        'number'
    ];
}
