<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;
    protected $table = 'topup';
    protected $guarded = [];

    public function bonus_detail()
    {
        return $this->hasOne(Dokter::class, 'username', 'dari');
    }
}
