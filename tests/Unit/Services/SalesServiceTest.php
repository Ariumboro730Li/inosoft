<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Repositories\VehicleRepository;
use App\Repositories\PenjualanRepository;
use App\Services\Actions\StoreService;
use App\Services\SalesService;
use Illuminate\Http\Request;
use Mockery;

class SalesServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testStoreSalesWithValidVehicle()
    {
        // // Arrange
        $type = 'mobil';
        $kendaraanId = 123;
        $vehicle = [
            "_id" => $kendaraanId,
            "mesin" => 3723,
            "kapasitas" => 4,
            "tipe" => "SUV",
            "stok" => 65,
        ];

        $requestMock = Mockery::mock(Request::class);
        $requestMock->kendaraan_id = $kendaraanId;

        $vehicleRepositoryMock = Mockery::mock(VehicleRepository::class);
        $vehicleRepositoryMock->shouldReceive('setModel')->with($type)->andReturnSelf();
        $vehicleRepositoryMock->shouldReceive('getVehicleById')->with($kendaraanId)->andReturn(collect($vehicle));

        $storeServiceMock = $this->getMockBuilder(StoreService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $storeServiceMock->expects($this->once())
            ->method('setType')
            ->with($type)
            ->willReturn($storeServiceMock);
        $storeServiceMock->expects($this->once())
            ->method('setDataSale')
            ->with(collect($vehicle))
            ->willReturn($storeServiceMock);
        $storeServiceMock->expects($this->once())
            ->method('applyActions')
            ->willReturn($storeServiceMock);
        $storeServiceMock->expects($this->once())
            ->method('toArray')
            ->willReturn(['result']);


        $penjualanRepositoryMock = Mockery::mock(PenjualanRepository::class);

        $salesService = new SalesService(
            $requestMock,
            $penjualanRepositoryMock,
            $vehicleRepositoryMock,
            $storeServiceMock
        );

        $result = $salesService->storeSales($type);
        $this->assertEquals(201, $result->getStatusCode());
    }

    public function testStoreSalesWithInvalidVehicle()
    {
        // Arrange
        $type = 'mobil';
        $kendaraanId = 123;
        $vehicle = [];

        $requestMock = Mockery::mock(Request::class);
        $requestMock->kendaraan_id = $kendaraanId;

        $vehicleRepositoryMock = Mockery::mock(VehicleRepository::class);
        $vehicleRepositoryMock->shouldReceive('setModel')->with($type)->andReturnSelf();
        $vehicleRepositoryMock->shouldReceive('getVehicleById')->with($kendaraanId)->andReturn(null);

        $penjualanRepositoryMock = Mockery::mock(PenjualanRepository::class);

        $salesService = new SalesService(
            $requestMock,
            $penjualanRepositoryMock,
            $vehicleRepositoryMock,
            $this->app->make(StoreService::class)
        );

        $result = $salesService->storeSales($type);
        $this->assertEquals(404, $result->getStatusCode());
    }

    public function testReportSales()
    {
        // Arrange
        $type = 'mobil';
        $expectedResult = [
            ['kendaraan_id' => 123, 'total_penjualan' => 'value1', 'jumlah_terjual' => 'value2'],
            ['kendaraan_id' => 456, 'total_penjualan' => 'value3', 'jumlah_terjual' => 'value4'],
        ];

        $repositoryMock = $this->createMock(PenjualanRepository::class);
        $repositoryMock->expects($this->once())
            ->method('groupSales')
            ->willReturn($expectedResult);

        $vehicleRepositoryMock = $this->createMock(VehicleRepository::class);
        $vehicleRepositoryMock->expects($this->exactly(count($expectedResult)))
            ->method('setModel')
            ->withConsecutive(
                [$type],
                [$type],
            )
            ->willReturnOnConsecutiveCalls(
                $vehicleRepositoryMock,
                $vehicleRepositoryMock);
        $vehicleRepositoryMock->expects($this->exactly(count($expectedResult)))
            ->method('getVehicleById')
            ->withConsecutive(
                [123],
                [456],
            )
            ->willReturnOnConsecutiveCalls($expectedResult[0], $expectedResult[1]);

        $salesService = new SalesService(
            $this->app->make(Request::class),
            $repositoryMock,
            $vehicleRepositoryMock,
            $this->app->make(StoreService::class)
        );

        // Act
        $response = $salesService->reportSales($type);
        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals( json_decode($response->getContent(), true), $expectedResult);
    }

    public function testReportSalesFailed()
    {
        $type = 'mobil';
        $expectedResult = [];
        $idType = [
            [123],
            [456],
        ];

        $response = $this->returnTestReportSales($type, $expectedResult, $idType);
        // Assert
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals( json_decode($response->getContent(), true), ["Tidak ada data penjualan"]);
    }

    public function testReportSalesById()
    {
        // Arrange
        $type = 'mobil';
        $id = 123;
        $penjualanData = [
            // Sample penjualan data
            [
                "kendaraan_id" => 1,
                "total_penjualan" => "value1",
                "jumlah_terjual" => "value2",
            ],
            [
                "kendaraan_id" => 2,
                "total_penjualan" => "value3",
                "jumlah_terjual" => "value4",
            ],
        ];
        $vehicleData = [
            // Sample vehicle data
            [
                "kendaraan_id" => 1,
                "name" => "Vehicle 1",
            ],
            [
                "kendaraan_id" => 2,
                "name" => "Vehicle 2",
            ],
        ];

        $response = $this->returnTestReportSalesById($type, $id, $penjualanData, $vehicleData);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testReportSalesByIdFailed()
    {
        // Arrange
        $type = 'mobil';
        $id = 123;

        // ? set data empty
        $penjualanData = [];
        $vehicleData = [
            [
                "kendaraan_id" => 1,
                "name" => "Vehicle 1",
            ],
            [
                "kendaraan_id" => 2,
                "name" => "Vehicle 2",
            ],
        ];

        $response = $this->returnTestReportSalesById($type, $id, $penjualanData, $vehicleData);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function returnTestReportSales($type, $expectedResult, $idType){
        $repositoryMock = $this->createMock(PenjualanRepository::class);
        $repositoryMock->expects($this->once())
            ->method('groupSales')
            ->willReturn($expectedResult);

        $vehicleRepositoryMock = $this->createMock(VehicleRepository::class);
        $vehicleRepositoryMock->expects($this->exactly(count($expectedResult)))
            ->method('getVehicleById')
            ->withConsecutive(
                $idType[0], $idType[1]
            )
            ->willReturnOnConsecutiveCalls([]);

        $salesService = new SalesService(
            $this->app->make(Request::class),
            $repositoryMock,
            $vehicleRepositoryMock,
            $this->app->make(StoreService::class)
        );

        // Act
        $response = $salesService->reportSales($type);

        return $response;
    }


    public function returnTestReportSalesById($type, $id, $penjualanData, $vehicleData){

        $repositoryMock = Mockery::mock(PenjualanRepository::class);
        $repositoryMock->shouldReceive('reportSalesById')->with($type, $id)->andReturn($penjualanData);

        $vehicleRepositoryMock = Mockery::mock(VehicleRepository::class);
        $vehicleRepositoryMock->shouldReceive('setModel')->with($type)->andReturnSelf();
        $vehicleRepositoryMock->shouldReceive('getVehicleById')->andReturn($vehicleData[0], $vehicleData[1]);

        $salesService = new SalesService(
            Mockery::mock(Request::class),
            $repositoryMock,
            $vehicleRepositoryMock,
            Mockery::mock(StoreService::class)
        );

        $response = $salesService->reportSalesById($type, $id);
        return $response;
    }

}
