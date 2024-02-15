<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PopAmarta extends Model
{
    protected $table = 'pop_amarta_0223';
    protected $fillable = ['pop_id', 'pop_name', 'lat', 'long', 'pop_address'];

    public static function getPopData()
    {
        return DB::table('pop_amarta_0223')->select('objectid', 'id', 'pop_id', 'pop_name', 'lat', 'lng', 'created_at', 'accessibility', 'hierarchy_type', 'activation_stage', 'construction_stage', 'r08_status_data', 'r09_info_data', 'r10_kategori_lokasi', 'pop_address', 'district', 'sub_district', 'city', 'installation_date', 'installation_year', 'pop_type', 'pop_model_name', 'prov_name', 'shape')->get();
        //return DB::select('select * from pop_amarta_0223');

    }

    protected $connection = 'pgsql';
    protected $host = '10.14.204.109';
    protected $database = 'agricom';
    protected $username = 'useragricom';
    protected $password = 'Agricom@123';
}


