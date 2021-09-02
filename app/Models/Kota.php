<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;
    protected $table = 'city';
    protected $primaryKey = 'city_id';
    public $incrementing = false;


    public function kec()
    {
        return $this->hasMany(Kecamatan::class, 'city_id');
    }
}
