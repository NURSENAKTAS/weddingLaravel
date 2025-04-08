<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paketler extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'organizasyon_id',
        'mekan_id',
        'susleme_id',
        'menu_ogeleri_id',
        'pasta_id',
        'paket_adi',
        'temel_fiyat',
        'ekstra_fiyat',
        'olusturulma_tarihi',
        'guncellenme_tarihi'
    ];

    public function Mekanlar()
    {
        return $this->belongsTo(Mekanlar::class);
    }

    public function Suslemeler()
    {
        return $this->belongsTo(Suslemeler::class);
    }

    public function Randevu()
    {
        return $this->hasMany(Randevu::class);
    }

    public function MenuOgeleri()
    {
        return $this->belongsTo(Menu_ogeleri::class);
    }

    public function Pastalar()
    {
        return $this->belongsTo(Pastalar::class);
    }
    public function Organizasyonlar()
    {
        return $this->belongsTo(Organizasyonlar::class);
    }
}
