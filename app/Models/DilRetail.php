<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DilRetail extends Model
{
    protected $table = 'pelanggan_iconnet';
    protected $fillable = ['idpelanggan','idpln','namasbu','status','detailstatus','product'];
    public static function getpelanggan_iconnet()
     {
         return DB::table('pelanggan_iconnet')->select('idpelanggan','idpln', 'namasbu', 'status', 'detailstatus', 'product', 'bandwidth', 'tanggaldaftar', 'tanggalpembayaran', 'tanggalaktivasi', 'latitude', 'longitude', 'modifieddate', 'nopa', 'tanggalpa', 'tanggaldisposisi', 'generated_date', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'namakp')->limit(100)->get();
     }
     protected $connection = 'pgsql';
     protected $host = '10.14.204.109';
     protected $database = 'agricom';
     protected $username = 'useragricom';
     protected $password = 'Agricom@123';
}
