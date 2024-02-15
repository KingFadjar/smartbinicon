<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kapasitassampah extends Model
{
    protected $table = 'ultrasonic_data';
    protected $fillable = [
        'lat',
        'lng',
        'kosong',
        'setengah',
        'penuh',
        'kapasitas_sampah',
        'kapasitas_mobil',
        'status',
        'alamat',
    ];

    public static function getUltrasonicDataArray()
    {
        return self::select('lat', 'lng', 'kosong', 'setengah', 'penuh', 'kapasitas_sampah', 'kapasitas_mobil', 'alamat')->get()->toArray();
    }
}
