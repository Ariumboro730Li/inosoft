<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $visible = ['tahun', 'warna', 'harga'];
    protected $fillable = ['tahun', 'warna', 'harga'];
}
