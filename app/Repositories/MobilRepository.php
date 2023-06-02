<?php

namespace App\Repositories;

use App\Models\Mobil;
use App\Interfaces\VehicleRepositoryInterface;

class MobilRepository implements VehicleRepositoryInterface
{
    public function getVehicle()
    {
        return Mobil::with('kendaraan')->get();
    }

    public function getVehicleById($id)
    {
        return Mobil::with('kendaraan')->where('_id', $id)->first();
    }
}
