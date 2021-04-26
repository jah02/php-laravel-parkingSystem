<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function getTime(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\CarTime');
    }
}
