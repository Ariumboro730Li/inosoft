<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\VehicleRepository;
use App\Services\Actions\StoreService;
use App\Repositories\PenjualanRepository;

class SalesService
{

    protected $request;
    protected $repository;
    protected $vehicleRepository;
    protected $storeService;
    private $http_code = 200;


    public function __construct(Request $request, PenjualanRepository $repository, VehicleRepository $vehicleRepository, StoreService $storeService)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->vehicleRepository = $vehicleRepository;
        $this->storeService = $storeService;
    }

    public function storeSales(string $type)
    {
        $vehicle = $this->vehicleRepository->setModel($type)->getVehicleById($this->request->kendaraan_id);
        if ($vehicle) {
            $result = $this->storeService->setType($type)->setDataSale($vehicle)->applyActions()->toArray();
        } else {
            $result = ["error" => "Kendaraan tidak ditemukan"];
            $this->http_code = 404;
        }
        return response()->json($result, $this->http_code);
    }


    public function reportSales(string $type)
    {
        $result = [];
        $data = $this->repository->groupSales();
        foreach ($data as $key => $value) {
            $vehicle = $this->vehicleRepository->setModel($type)->getVehicleById($value["kendaraan_id"]);
            if ($vehicle) {
                $vehicleArray = is_array($vehicle) ? $vehicle : $vehicle->toArray();
                $result[] = array_merge($vehicleArray, ["total_penjualan" => $value["total_penjualan"], "jumlah_terjual" => $value["jumlah_terjual"]]);
            }
        }
        if (!$result) {
            $result = ["Tidak ada data penjualan"];
            $this->http_code = 404;
        }

        return response()->json($result ?? ["Tidak ada data penjualan"], $this->http_code);
    }

    public function reportSalesById(string $type, $id){
        $penjualan = $this->repository->reportSalesById($type, $id);
        if ($penjualan) {
            foreach ($penjualan as $key => $value) {
                $vehicle = $this->vehicleRepository->setModel($type)->getVehicleById($value["kendaraan_id"]);
                $value_array = is_array($value) ? $value : $value->toArray();
                $vehicle_array = is_array($vehicle) ? $vehicle : $vehicle->toArray();
                $result[] = array_merge($value_array, ["data" => $vehicle_array]);
            }
        } else {
            $this->http_code = 404;
        }
        return response()->json($result ?? ["Tidak ada data penjualan untuk $type ID $id"], $this->http_code);
    }

}
