<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizasyonlar extends Model
{
    public $timestamps = false;
    public function Paketler()
    {
        return $this-> hasMany(Paketler::class);
    }
}
