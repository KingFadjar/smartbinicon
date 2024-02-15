<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Role extends Model
{
    use HasFactory;

    protected $table = 'users';

    public function users()
    {
        return $this->hasMany('App\Models\User', 'role_id');
    }
}
