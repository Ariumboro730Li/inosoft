<?php

namespace App\Http\Controllers;

use App\Services\Stok\MobilService;
use App\Services\Stok\MotorService;
use Illuminate\Http\Request;

class StokController extends Controller
{
    protected Request $request;
    protected MobilService $mobilService;
    protected MotorService $motorService;

    public function __construct(request $request, MobilService $mobilService, MotorService $motorService)
    {
        $this->request = $request;
        $this->MobilService = $mobilService;
        $this->MotorService = $motorService;
    }

    public function mobil()
    {
        return $this->MobilService->getVehicle();
    }

    public function motor()
    {
        return $this->MotorService->getVehicle();
    }
}
