<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TampilData extends Model
{
    use HasFactory;

    protected $table = 'data'; // Set the table name to match the existing table
    protected $primaryKey = 'id'; // Set the primary key if it's different
    public $timestamps = false; // Set to true if timestamps are used in the 'data' table

    protected $fillable = [
        'alamat',
        'tanggal',
        'indikator',
        'kapasitas',
        'koordinat',
    ];
}
