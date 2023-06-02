<?php

namespace App\Services;

use App\Repositories\VehicleRepository;
use Illuminate\Http\Request;

class VehicleService
{
    protected $request;
    protected $repository;

    public function __construct(Request $request, VehicleRepository $vehicleRepository)
    {
        $this->request = $request;
        $this->repository = $vehicleRepository;
    }

    public function getVehicle(string $type): object
    {
        return response()->json($this->repository->getVehicle($type));
    }

    public function getVehicleById(string $type, $id): object
    {
        return response()->json($this->repository->getVehicleById($id, $type));
    }
}
