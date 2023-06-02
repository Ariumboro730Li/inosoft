<?php

namespace App\Interfaces;

interface VehicleRepositoryInterface
{
    public function getVehicle();
    public function getVehicleById($id);

}
