<?php

namespace Tests\Unit\Services\Actions;

use Tests\TestCase;
use App\Services\Actions\StoreService;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use Mockery;

class StoreServiceTest extends TestCase
{
    public function testApplyActionsWithSufficientStock()
    {

        $requestMock = new request([
            'jumlah' => 5
        ]);

        // Create a mock of the Vehicle object
        $vehicleMock = Mockery::mock(\stdClass::class);
        $vehicleMock->stok = 10;
        $vehicleMock->shouldReceive('update')->once()->with(['stok' => 5])->andReturnNull();
        $vehicleMock->shouldReceive('toArray')->andReturn(['vehicle1']);

        // Create a mock of the Penjualan object
        $penjualanMock = Mockery::mock(Penjualan::class);
        $penjualanMock->shouldReceive('create')->once()->andReturn($penjualanMock);
        $penjualanMock->shouldReceive('toArray')->andReturn(['penjualan1']);

        // Create an instance of the StoreService using the mock objects
        $storeService = new StoreService($requestMock, $penjualanMock);
        $storeService->setType('mobil')->setDataSale($vehicleMock);

        // Call the method being tested
        $result = $storeService->applyActions()->toArray();

        // Perform assertions on the result
        $this->assertEquals(['penjualan' => ['penjualan1'], 'kendaraan' => ['vehicle1']], $result);
    }

    public function testApplyActionsWithInsufficientStock()
    {
        // Create a mock of the Request
        $requestMock = new request([
            'jumlah' => 8
        ]);

        // Create a mock of the Vehicle object
        $vehicleMock = Mockery::mock(\stdClass::class);
        $vehicleMock->stok = 5;
        $vehicleMock->shouldReceive('toArray')->andReturn(['Stok Tidak Cukup']);

        // Create a mock of the Penjualan object
        $penjualanMock = Mockery::mock(Penjualan::class);

        // Create an instance of the StoreService using the mock objects
        $storeService = new StoreService($requestMock, $penjualanMock);
        $storeService->setType('mobil')->setDataSale($vehicleMock);

        // Call the method being tested
        $result = $storeService->applyActions()->toArray();
        // Perform assertions on the result
        $this->assertEquals([
            'penjualan' => [],
            'kendaraan' => [
                'Stok Tidak Cukup'
            ]
        ], $result);
    }

    public function testApplyActionsWithEmptyStock()
    {
        // Create a mock of the Request
        $requestMock = new request([
            'jumlah' => 8
        ]);

        // Create a mock of the Vehicle object
        $vehicleMock = null;
        // Create a mock of the Penjualan object
        $penjualanMock = Mockery::mock(Penjualan::class);

        // Create an instance of the StoreService using the mock objects
        $storeService = new StoreService($requestMock, $penjualanMock);
        $storeService->setType('mobil')->setDataSale($vehicleMock);

        // Call the method being tested
        $result = $storeService->applyActions()->toArray();
        // Perform assertions on the result
        $this->assertEquals([
            'penjualan' => [],
            'kendaraan' => [
                'ID Tidak Ada'
            ]
        ], $result);
    }
}
