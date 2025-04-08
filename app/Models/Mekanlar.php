<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mekanlar extends Model
{
    public $timestamps = false;
    public function randevu()
    {
        return $this->belongsToMany(Randevu::class, 'mekan_randevus');
    }
    public function Paketler()
    {
        return $this->hasMany(Paketler::class );
    }
}
