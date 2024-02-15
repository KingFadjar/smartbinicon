<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DataSampah extends Model
{
    use HasFactory;

    protected $fillable = [
        'alamat',
        'tanggal',
        'indikator',
        'sampah',
        'kapasitas',
        'titik_koordinat',
    ];

}
