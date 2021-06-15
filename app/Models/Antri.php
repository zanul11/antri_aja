<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antri extends Model
{
    use HasFactory;
    protected $table = 'antri';
    protected $guarded = [];

    public function dokter_detail()
    {
        return $this->hasOne(Dokter::class, 'id', 'dokter');
    }

    public function waktu_detail()
    {
        return $this->hasOne(Jadwal::class, 'id', 'waktu');
    }
}
