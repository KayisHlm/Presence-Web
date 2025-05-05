<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Cuti (tidak perlu merubah keyName)
class Cuti extends Model
{
    use HasFactory;

    protected $table = 'cutis';
    public $incrementing = false;  // Menandakan bahwa ini bukan auto-increment
    protected $primaryKey = ['user_id', 'jenis_cuti', 'tanggal'];  // Primary key gabungan
    protected $fillable = ['user_id', 'jenis_cuti', 'tipe_pengajuan', 'tanggal', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}


