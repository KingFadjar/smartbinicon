<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DilJatengKorporat extends Model
{
    // protected $table = 'dil_jateng_korporat';
    // protected $fillable = ['pop_id', 'pop_name', 'lat', 'long', 'pop_address'];

    public static function getDilJatengKorporat()
    {
        return DB::table('dil_jateng_korporat')->select('tarif', 'daya', 'nama', 'idpel','koordinat', 'x', 'y')->get();
        //return DB::select('select * from pop_amarta_0223');

    }

   //  protected $connection = 'pgsql';
   // protected $host = '10.14.204.109';
   // protected $database = 'agricom';
   // protected $username = 'useragricom';
   //  protected $password = 'Agricom@123';
}