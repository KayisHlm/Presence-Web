<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_login'; // <--- INI PENTING
    
    protected $primaryKey = 'id'; // Karena kamu pakai string id custom
    public $incrementing = false; // Karena id bukan auto-increment
    protected $keyType = 'string'; // Karena id bertipe string

    protected $fillable = [
        'id',
        'nama',
        'email',
        'password',
        'posisi',
        'role',
        'gaji'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
