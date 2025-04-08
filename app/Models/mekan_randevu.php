<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mekan_randevu extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "mekan_id",
        "randevus_id"
    ];
}
