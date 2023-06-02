<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = ['kendaraan_id', 'nama', 'jumlah', 'tanggal', 'alamat', 'type_kendaraan'];
    protected $visible = ['_id', 'kendaraan_id', 'nama', 'jumlah', 'tanggal', 'alamat', 'type_kendaraan'];

    protected $casts = [
        "tanggal" => "date:Y-m-d H:i:s"
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->setTimezone("Asia/Jakarta")->format("Y-m-d H:i:s");
    }

}
