<?php

namespace App\Services;

use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;
use App\Repositories\VehicleRepository;
use App\Services\Actions\StoreService;
use App\Repositories\PenjualanRepository;

class SalesService
{

    protected $request;
    protected $repository;
    protected $vehicleRepository;
    protected $storeService;

    public function __construct(Request $request, PenjualanRepository $repository, VehicleRepository $vehicleRepository, StoreService $storeService)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->vehicleRepository = $vehicleRepository;
        $this->storeService = $storeService;
    }

    public function storeSales(string $type): array
    {
        $this->request->merge([
            "type_kendaraan" => $type,
            "tanggal" => new UTCDateTime
        ]);
        $vehicle = $this->vehicleRepository->getVehicleById($this->request->kendaraan_id, $type);
        return $this->storeService->applyActions($vehicle)->toArray();
    }

    public function reportSales(string $type){
        $data = $this->repository->groupSales();
        foreach ($data as $key => $value) {
            $vehicle = $this->vehicleRepository->getVehicleById($value["kendaraan_id"], $type);
            if ($vehicle) {
                $result[] = array_merge($vehicle->toArray(), ["total_penjualan" => $value["total_penjualan"], "jumlah_terjual" => $value["jumlah_terjual"]]);
            }
        }
        return response()->json($result);
    }

    public function reportSalesById(string $type, $id){
        $penjualan = $this->repository->reportSalesById($type, $id);
        foreach ($penjualan as $key => $value) {
            $vehicle = $this->vehicleRepository->getVehicleById($value["kendaraan_id"], $type);
            $data[] = array_merge($value->toArray(), ["data" => $vehicle->toArray()]);
        }
        return response()->json($data ?? ["Tidak ada data penjualan untuk $type ID $id"]);
    }

}
