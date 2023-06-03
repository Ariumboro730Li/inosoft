<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\MobilRepository;
use App\Models\Mobil;
use App\Interfaces\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Illuminate\Support\Str;


class MobilRepositoryTest extends TestCase
{
    public function testGetVehicle()
    {
        Mobil::truncate();
        // Create test data in the database for the Penjualan model
        $penjualan = Mobil::factory()->create([
            "mesin" => "1000",
            "kapasitas" => "2",
            "tipe" => "SUV",
            "stok" => "100"
        ]);

        // Create an instance of the repository
        $repository = new MobilRepository();

        // Call the method being tested
        $result = $repository->getVehicle();

        // Perform assertions on the result
        $this->assertCount(1, $result);
        $this->assertEquals($penjualan->mesin, $result->first()->mesin);
    }

    public function testGetVehicleById(){
        $kendaraan_id = Str::random(10);
        // Create test data in the database for the Mobil model
        $mobil = Mobil::factory()->create([
            "_id" => $kendaraan_id,
            "mesin" => "1000",
            "kapasitas" => "2",
            "tipe" => "SUV",
            "stok" => "100"
        ]);

        // Create an instance of the repository
        $repository = new MobilRepository();

        // Call the method being tested
        $result = $repository->getVehicleById($kendaraan_id);
        $this->assertEquals($mobil->_id, $result->_id);

    }

}
