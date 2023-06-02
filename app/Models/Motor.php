<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $visible = ['_id', 'mesin', 'tipe_suspensi', 'tipe_transmisi', 'stok', 'kendaraan'];
    protected $fillable = ['stok'];

    /**
     * Get the related Kendaraan record.
     */
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
