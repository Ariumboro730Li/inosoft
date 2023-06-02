<?php

namespace App\Repositories;

use App\Models\Motor;
use App\Interfaces\VehicleRepositoryInterface;

class MotorRepository implements VehicleRepositoryInterface
{
    public function getVehicle()
    {
        return Motor::with('kendaraan')->get();
    }

    public function getVehicleById($id)
    {
        return Motor::with('kendaraan')->where('_id', $id)->first();
    }
}
