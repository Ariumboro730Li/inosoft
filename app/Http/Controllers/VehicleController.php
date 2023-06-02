<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Services\SalesService;
use Illuminate\Http\Request;
use App\Services\VehicleService;

class VehicleController extends Controller
{
    protected Request $request;
    protected VehicleService $service;
    protected SalesService $salesService;

    public function __construct(Request $request, VehicleService $vehicleService, SalesService $salesService)
    {
        $this->request = $request;
        $this->vehicleService = $vehicleService;
        $this->salesService = $salesService;
    }

    public function stok($type)
    {
        return $this->vehicleService->getVehicle($type);
    }

    public function stokById($type, $id)
    {
        return $this->vehicleService->getVehicleById($type, $id);
    }

    public function storeSales(StoreRequest $request, $type)
    {
        return $this->salesService->storeSales($type);
    }

    public function report($type)
    {
        return $this->salesService->reportSales($type);
    }

    public function reportById($type, $id)
    {
        return $this->salesService->reportSalesById($type, $id);
    }
}
