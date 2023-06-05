<?php

namespace App\Repositories;

use App\Models\Mobil;
use App\Models\Motor;

class VehicleRepository
{
    protected object $model;
    protected Mobil $mobil;
    protected Motor $motor;

    public function __construct(Mobil $mobil, Motor $motor)
    {
        $this->mobil = $mobil;
        $this->motor = $motor;
    }

    public function setModel(string $model){
        if ($model == "mobil") {
            $this->model = $this->mobil;
        } else {
            $this->model = $this->motor;
        }

        return $this;
    }

    public function getVehicle()
    {
        return $this->model::with('kendaraan')->whereNotNull("_id")->get();
    }

    public function getVehicleById($id)
    {
        return $this->model::with('kendaraan')->where('_id', $id)->first();
    }
}

