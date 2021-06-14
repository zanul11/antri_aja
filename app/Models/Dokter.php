<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Dokter extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $guarded = [];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_user', 'id');
    }

    public function spesialis_detail()
    {
        return $this->hasOne(Spesialis::class, 'id', 'spesialis');
    }

    public function antri()
    {
        return $this->hasMany(Antri::class, 'dokter', 'id');
    }
}
