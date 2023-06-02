<?php

namespace App\Repositories;

use App\Repositories\MotorRepository;
use App\Repositories\MobilRepository;

class VehicleRepository
{
    public function getVehicle($type)
    {
        if ($type === 'mobil') {
            return (new MobilRepository())->getVehicle();
        } elseif ($type === 'motor') {
            return (new MotorRepository())->getVehicle();
        }

        return null;
    }

    public function getVehicleById($id, $type)
    {
        if ($type === 'mobil') {
            return (new MobilRepository())->getVehicleById($id);
        } elseif ($type === 'motor') {
            return (new MotorRepository())->getVehicleById($id);
        }

        return null;
    }
}

