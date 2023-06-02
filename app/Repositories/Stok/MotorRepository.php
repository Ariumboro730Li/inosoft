<?php

namespace App\Repositories\Stok;

use App\Models\Motor;

class MotorRepository
{
    public function getMobil()
    {
        return Mobil::with('kendaraan')->get();
    }
}
