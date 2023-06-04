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
        $vehicles = $this->repository->setModel($type)->getVehicle();
        return $this->returnResponse($vehicles);
    }

    public function getVehicleById(string $type, $id): object
    {
        $vehicles = $this->repository->setModel($type)->getVehicleById($id);
        return $this->returnResponse($vehicles);
    }

    private function returnResponse($vehicles){
        if (!$vehicles) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        return response()->json($vehicles, 200);
    }
}
