<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\VehicleService;
use App\Repositories\VehicleRepository;
use Illuminate\Http\Request;
use Mockery;

class VehicleServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetVehicle()
    {
        // Create a mock of the Request class
        $request = Mockery::mock(Request::class);

        // Create a mock of the VehicleRepository class
        $repository = Mockery::mock(VehicleRepository::class);
        $repository->shouldReceive('setModel')->with('mobil')->andReturnSelf();
        $repository->shouldReceive('getVehicle')->andReturn([]);

        // Create an instance of the service class with the mocked dependencies
        $service = new VehicleService($request, $repository);

        // Call the method being tested
        $result = $service->getVehicle('mobil');

        // Perform assertions on the result
        $this->assertIsObject($result);
        // Add additional assertions as needed
    }

    public function testGetVehicleById()
    {
        $id = 'example_id';

        // Create a mock of the Request class
        $request = Mockery::mock(Request::class);

        // Create a mock of the VehicleRepository class
        $repository = Mockery::mock(VehicleRepository::class);
        $repository->shouldReceive('setModel')->with('mobil')->andReturnSelf();
        $repository->shouldReceive('getVehicleById')->with($id)->andReturn([]);

        // Create an instance of the service class with the mocked dependencies
        $service = new VehicleService($request, $repository);

        // Call the method being tested
        $result = $service->getVehicleById('mobil', $id);

        // Perform assertions on the result
        $this->assertIsObject($result);
        // Add additional assertions as needed
    }
}
