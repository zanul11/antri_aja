<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTable extends Model
{
    use HasFactory;
    protected $table = 'request';
    protected $guarded = [];

    public function faskes_detail()
    {
        return $this->hasOne(Dokter::class, 'email', 'faskes');
    }
    public function nakes_detail()
    {
        return $this->hasOne(Dokter::class, 'id', 'nakes');
    }
}
