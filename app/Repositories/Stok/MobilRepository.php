<?php

namespace App\Repositories\Stok;

use App\Models\Mobil;

class MobilRepository
{
    public function getMobil()
    {
        return Mobil::with('kendaraan')->get();
    }
}
