<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\VehicleRepository;
use App\Models\Mobil;
use App\Models\Motor;
use Illuminate\Support\Str;
use Mockery;

class VehicleRepositoryTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetVehicle()
    {
        // Create a mock of the Mobil model
        $mobil = Mockery::mock(Mobil::class);
        $mobil->shouldReceive('with')->with('kendaraan')->andReturnSelf();
        $mobil->shouldReceive('get')->andReturn([]);

        // Create a mock of the Mobil model
        $motor = Mockery::mock(Motor::class);
        $motor->shouldReceive('with')->with('kendaraan')->andReturnSelf();
        $motor->shouldReceive('get')->andReturn([]);

        // Create an instance of the repository with the mocked dependencies
        $repository = new VehicleRepository($mobil, $motor);

        // Call the method being tested
        $resultMobil= $repository->setModel("mobil")->getVehicle();
        $resultMotor= $repository->setModel("motor")->getVehicle();

        // Perform assertions on the result
        $this->assertIsArray($resultMobil);
        $this->assertIsArray($resultMotor);
        // Add additional assertions as needed
    }

    public function testGetVehicleById()
    {
        $kendaraan_id = Str::random(10);

        // Create a mock of the Mobil model
        $mobil = Mockery::mock(Mobil::class);
        $mobil->shouldReceive('with')->with('kendaraan')->andReturnSelf();
        $mobil->shouldReceive('where')->with('_id', $kendaraan_id)->andReturnSelf();
        $mobil->shouldReceive('first')->andReturn([]);

        // Create an instance of the repository with the mocked dependencies
        $repository = new VehicleRepository($mobil, new Motor());

        // Call the method being tested
        $result = $repository->setModel("mobil")->getVehicleById($kendaraan_id);

        // Perform assertions on the result
        $this->assertIsArray($result);
        // Add additional assertions as needed
    }
}
