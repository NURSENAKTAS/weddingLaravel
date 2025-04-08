<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rezervasyonlar extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'randevu_id',
        'rezervasyon_durum',
        'olusturulma_tarihi',
        'guncelleme_tarihi'
    ];

    public function Randevu()
    {
        return $this->belongsTo(Randevu::class);
    }

    public function Odeme()
    {
        return $this->hasOne(Odemeler::class);
    }
}
