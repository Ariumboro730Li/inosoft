<?php

namespace App\Services\Actions;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;

class StoreService
{
    protected Request $request;
    protected array $vehicle;
    protected array $penjualan;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function applyActions(object $vehicle){
        if ($vehicle && $vehicle->stok >= $this->request->jumlah) {
            $this->updateVehicleStock($vehicle);
            $this->storeSales();
        } else {
            if (!$vehicle) {
                $this->vehicle = ["ID Tidak Ada"];
            } else if ($vehicle->stok < $this->request->jumlah) {
                $this->vehicle = ["Stok Tidak Cukup"];
            }
        }

        return $this;
    }

    public function updateVehicleStock(?object $vehicle){
        $stok = $vehicle->stok - $this->request->jumlah;
        $vehicle->update(['stok' => $stok]);
        $this->vehicle = $vehicle->toArray();
        return $this;
    }

    public function storeSales(){
        $data = array_merge($this->request->all(), ["tanggal" => new UTCDateTime]);
        $penjualan = Penjualan::create($data);
        $this->penjualan = $penjualan->toArray();
        return $this;
    }

    public function toArray(){
        return [
            "penjualan" => $this->penjualan ?? [],
            "kendaraan" => $this->vehicle ?? []
        ];
    }
}
