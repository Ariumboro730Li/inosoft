<?php

namespace Tests\Unit;

use App\Http\Controllers\VehicleController;
use App\Http\Requests\StoreRequest;
use App\Services\SalesService;
use App\Services\VehicleService;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class VehicleControllerTest extends TestCase
{
    public function testStokReturnsData()
    {
        // Arrange
        $vehicleServiceMock = $this->createMock(VehicleService::class);
        $vehicleServiceMock->expects($this->once())
            ->method('getVehicle')
            ->with('type1')
            ->willReturn((object) ['Innova Zenix', 'Hyundai Palisade']);

        $controller = new VehicleController(
            $this->createMock(Request::class),
            $vehicleServiceMock,
            $this->createMock(SalesService::class)
        );

        // Act
        $result = $controller->stok('type1');

        // Assert
        $this->assertEquals((object) ['Innova Zenix', 'Hyundai Palisade'], $result);
    }

    public function testStokByIdReturnsData()
    {
        // Arrange
        $vehicleServiceMock = $this->createMock(VehicleService::class);
        $vehicleServiceMock->expects($this->once())
            ->method('getVehicleById')
            ->with('type1', 123)
            ->willReturn((object) ['Innova Zenix']);

        $controller = new VehicleController(
            $this->createMock(Request::class),
            $vehicleServiceMock,
            $this->createMock(SalesService::class)
        );

        // Act
        $result = $controller->stokById('type1', 123);

        // Assert
        $this->assertEquals((object) ['Innova Zenix'], $result);
    }

    public function testStoreSalesCallsSalesService()
    {
        // Arrange
        $requestMock = $this->createMock(StoreRequest::class);
        $salesServiceMock = $this->createMock(SalesService::class);
        $salesServiceMock->expects($this->once())
            ->method('storeSales')
            ->with('type1');

        $controller = new VehicleController(
            $this->createMock(Request::class),
            $this->createMock(VehicleService::class),
            $salesServiceMock
        );

        // Act
        $controller->storeSales($requestMock, 'type1');
    }

    public function testReportCallsSalesService()
    {
        // Arrange
        $salesServiceMock = $this->createMock(SalesService::class);
        $salesServiceMock->expects($this->once())
            ->method('reportSales')
            ->with('type1');

        $controller = new VehicleController(
            $this->createMock(Request::class),
            $this->createMock(VehicleService::class),
            $salesServiceMock
        );

        // Act
        $controller->report('type1');
    }

    public function testReportByIdCallsSalesService()
    {
        // Arrange
        $salesServiceMock = $this->createMock(SalesService::class);
        $salesServiceMock->expects($this->once())
            ->method('reportSalesById')
            ->with('type1', 123)
            ->willReturn(['report1', 'report2']);

        $controller = new VehicleController(
            $this->createMock(Request::class),
            $this->createMock(VehicleService::class),
            $salesServiceMock
        );

        // Act
        $result = $controller->reportById('type1', 123);

        // Assert
        $this->assertEquals(['report1', 'report2'], $result);
    }
}


