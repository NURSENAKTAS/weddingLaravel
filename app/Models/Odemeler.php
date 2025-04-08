<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odemeler extends Model
{
    public $timestamps = false;

    public function Rezervasyonlar()
    {
        return $this->belongsTo(Rezervasyonlar::class);
    }
}
