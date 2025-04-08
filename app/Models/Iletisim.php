<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iletisim extends Model
{
    use HasFactory;
    
    protected $table = 'iletisims';
    
    protected $fillable = [
        'kullanici_id',
        'ad_soyad',
        'email',
        'konu',
        'mesaj',
        'durum',
        'olusturulma_tarihi'
    ];
    
    public function kullanici()
    {
        return $this->belongsTo(User::class, 'kullanici_id');
    }
}
