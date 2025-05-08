<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gajis';
    protected $keyType = 'string';
    public $incrementing = false;
    public $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'bonus', 'deduction', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getRouteKeyName()
    {
    return 'user_id';
    }

}
