<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lemburs';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'jam_lembur', 'tanggal', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
