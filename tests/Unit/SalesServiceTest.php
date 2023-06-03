<?php

namespace Tests\Unit\Services;

use App\Repositories\VehicleRepository;
use App\Repositories\PenjualanRepository;
use App\Services\Actions\StoreService;
use App\Services\SalesService;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
// use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\App;

class SalesServiceTest extends TestCase
{
    public function testStoreSalesWithValidVehicle()
    {
        // Arrange
        $type = 'mobil';
        $kendaraanId = 123;
        $vehicle = ['vehicle1', 'vehicle2'];

        $requestMock = $this->createMock(Request::class);
        $requestMock->kendaraan_id = $kendaraanId;

        $vehicleRepositoryMock = $this->createMock(VehicleRepository::class);
        $vehicleRepositoryMock->expects($this->once())
            ->method('getVehicleById')
            ->with($kendaraanId, $type)
            ->willReturn((object)$vehicle);

        $storeServiceMock = $this->getMockBuilder(StoreService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $storeServiceMock->expects($this->once())
            ->method('applyActions')
            ->with((object)$vehicle)
            ->willReturn($storeServiceMock);
        $storeServiceMock->expects($this->once())
            ->method('toArray')
            ->willReturn(['result']);

        $penjualanRepositoryMock = $this->createMock(PenjualanRepository::class);

        $salesService = new SalesService(
            $requestMock,
            $penjualanRepositoryMock,
            $vehicleRepositoryMock,
            $storeServiceMock
        );

        // Act
        $result = $salesService->storeSales($type);

        // Assert
        $this->assertEquals(['result'], $result);
    }

    public function testStoreSalesWithInvalidVehicle()
    {
        // Arrange
        $type = 'mobil';
        $kendaraanId = 123;

        $requestMock = $this->createMock(Request::class);
        $requestMock->kendaraan_id = $kendaraanId;

        $vehicleRepositoryMock = $this->createMock(VehicleRepository::class);
        $vehicleRepositoryMock->expects($this->once())
            ->method('getVehicleById')
            ->with($kendaraanId, $type)
            ->willReturn(null);

        $storeServiceMock = $this->createMock(StoreService::class);

        $penjualanRepositoryMock = $this->createMock(PenjualanRepository::class);

        $salesService = new SalesService(
            $requestMock,
            $penjualanRepositoryMock,
            $vehicleRepositoryMock,
            $storeServiceMock
        );

        // Act
        $result = $salesService->storeSales($type);

        // Assert
        $this->assertEquals(['error' => 'Vehicle not found'], $result);
    }
}
