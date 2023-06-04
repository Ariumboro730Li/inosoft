<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\VehicleService;
use App\Repositories\VehicleRepository;
use Illuminate\Http\Request;
use Mockery;

class VehicleServiceTest extends TestCase
{
    public function testGetVehicle()
    {
        // ? Create a mock of the VehicleRepository
        $vehicleRepository = Mockery::mock(VehicleRepository::class);
        $vehicleRepository->shouldReceive('setModel')->once()->with('mobil')->andReturnSelf();
        $vehicleRepository->shouldReceive('getVehicle')->once()->andReturn(collect(['Innova Zenix', 'Hyundai Palisade']));

        // ? Create a mock of the Request
        $request = Mockery::mock(Request::class);

        // Create an instance of the VehicleService using the mock objects
        $vehicleService = new VehicleService($request, $vehicleRepository);

        // Call the method being tested
        $response = $vehicleService->getVehicle('mobil');

        // Perform assertions on the response
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Innova Zenix', 'Hyundai Palisade'], $response->getData());
    }

    public function testGetVehicleById()
    {
        // ? Create a mock of the VehicleRepository
        $vehicleRepository = Mockery::mock(VehicleRepository::class);
        $vehicleRepository->shouldReceive('setModel')->once()->with('mobil')->andReturnSelf();
        $vehicleRepository->shouldReceive('getVehicleById')->once()->with(1)->andReturn('Innova Zenix');

        // ? Create a mock of the Request
        $request = Mockery::mock(Request::class);

        // Create an instance of the VehicleService using the mock objects
        $vehicleService = new VehicleService($request, $vehicleRepository);

        // Call the method being tested
        $response = $vehicleService->getVehicleById('mobil', 1);

        // Perform assertions on the response
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Innova Zenix', $response->getData());
    }

    public function testGetVehicleByIdNotFound()
    {
        // ? Create a mock of the VehicleRepository
        $vehicleRepository = Mockery::mock(VehicleRepository::class);
        $vehicleRepository->shouldReceive('setModel')->once()->with('mobil')->andReturnSelf();
        $vehicleRepository->shouldReceive('getVehicleById')->once()->with(1)->andReturn(null);

        // ? Create a mock of the Request
        $request = Mockery::mock(Request::class);

        // Create an instance of the VehicleService using the mock objects
        $vehicleService = new VehicleService($request, $vehicleRepository);

        // Call the method being tested
        $response = $vehicleService->getVehicleById('mobil', 1);

        // Perform assertions on the response
        $this->assertEquals(404, $response->getStatusCode());
    }
}
