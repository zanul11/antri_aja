<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $table = 'withdraw';
    protected $guarded = [];

    public function user_detail()
    {
        return $this->hasOne(Dokter::class, 'id', 'user');
    }
}
