<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = ['stok'];
    protected $visible = ['_id', 'mesin', 'kapasitas', 'tipe', 'stok', 'kendaraan'];

    /**
     * Get the related Kendaraan record.
     */
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
