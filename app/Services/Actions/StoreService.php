<?php

namespace App\Services\Actions;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;

class StoreService
{
    protected Request $request;
    protected $data;
    protected string $type;
    protected array $vehicle;
    protected array $penjualan;
    protected Penjualan $penjualanModel;

    public function __construct(Request $request, Penjualan $penjualanModel)
    {
        $this->request = $request;
        $this->penjualanModel = $penjualanModel;
    }

    public function setType($type){
        $this->type = $type;
        return $this;
    }

    public function setDataSale($data){
        $this->data = $data;
        return $this;
    }

    private function isSufficientStock(){
        return $this->data->stok >= $this->request->jumlah;
    }

    public function applyActions(){
        if ($this->data && $this->isSufficientStock()) {
            $this->updateVehicleStock($this->data);
            $this->storeSales();
        } else {
            if (!$this->data) {
                $this->vehicle = ["ID Tidak Ada"];
            } else if (!$this->isSufficientStock()) {
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
        $data = array_merge($this->request->all(), [
            "type_kendaraan" => $this->type,
            "tanggal" => new UTCDateTime
        ]);
        $penjualan = $this->penjualanModel->create($data);
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
