<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Randevu extends Model
{
    use HasFactory;

    protected $table = 'randevus';
    public $timestamps = false;
    protected $fillable = [
        'kullanici_id',
        'paket_id',
        'randevu_türü',
        'randevu_tarihi',
        'ozel_istekler',
        'olusturulma_tarihi',
        'guncelleme_tarihi'
    ];

    protected $dates = [
        'randevu_tarihi',
        'olusturulma_tarihi',
        'guncelleme_tarihi',
    ];

    public function kullanici()
    {
        return $this->belongsTo(User::class, 'kullanici_id');
    }

    public function Mekanlar()
    {
        return $this->belongsToMany(Mekanlar::class, 'mekan_randevus');
    }

    public function Paketler()
    {
        return $this->belongsTo(Paketler::class);
    }

    public function Rezervasyonlar()
    {
        return $this->hasMany(Rezervasyonlar::class);
    }
}
