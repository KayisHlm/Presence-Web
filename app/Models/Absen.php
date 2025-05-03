<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absens'; // Nama tabel
    
    protected $fillable = [
        'user_id', 'tanggal', 'check_in', 'check_out',
        'lokasi_latitude_in', 'lokasi_longitude_in',
        'lokasi_latitude_out', 'lokasi_longitude_out', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
