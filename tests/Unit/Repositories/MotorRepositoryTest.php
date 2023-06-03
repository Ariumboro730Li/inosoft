<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\MotorRepository;
use App\Models\Motor;
use App\Interfaces\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Illuminate\Support\Str;


class MotorRepositoryTest extends TestCase
{
    public function testGetVehicle()
    {
        Motor::truncate();
        // Create test data in the database for the Penjualan model
        $penjualan = Motor::factory()->create([
            "mesin" => "1000",
            "kapasitas" => "2",
            "tipe" => "SUV",
            "stok" => "100"
        ]);

        // Create an instance of the repository
        $repository = new MotorRepository();

        // Call the method being tested
        $result = $repository->getVehicle();

        // Perform assertions on the result
        $this->assertCount(1, $result);
        $this->assertEquals($penjualan->mesin, $result->first()->mesin);
    }

    public function testGetVehicleById(){
        $kendaraan_id = Str::random(10);
        // Create test data in the database for the Motor model
        $motor = Motor::factory()->create([
            "_id" => $kendaraan_id,
            "mesin" => "1000",
            "kapasitas" => "2",
            "tipe" => "SUV",
            "stok" => "100"
        ]);

        // Create an instance of the repository
        $repository = new MotorRepository();

        // Call the method being tested
        $result = $repository->getVehicleById($kendaraan_id);
        $this->assertEquals($motor->_id, $result->_id);

    }

}
