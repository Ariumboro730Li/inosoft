<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $visible = ['tahun', 'warna', 'harga'];
    /**
     * Get the owning kendaraanable model.
     */
    public function kendaraanable()
    {
        return $this->morphTo();
    }
}
