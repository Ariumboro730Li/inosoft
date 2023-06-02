<?php

namespace App\Services\Stok;

use App\Interfaces\StokServiceInterface;
use App\Repositories\Stok\MobilRepository;
use App\Repositories\VehicleRepository;

class MobilService implements StokServiceInterface
{
    protected $repository;

    public function __construct(MobilRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getVehicle(): object
    {
        return response()->json($this->repository->getMobil());
    }
}
