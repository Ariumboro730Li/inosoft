<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\PenjualanRepository;
use App\Models\Penjualan as PenjualanModel;
use Illuminate\Support\Str;
use Mockery;

class PenjualanRepositoryTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGroupSales()
    {
        // Set up any necessary data for the test
        // ...

        // Create an instance of the repository
        $repository = new PenjualanRepository();

        // Call the method being tested
        $result = $repository->groupSales();

        // Perform assertions on the result
        $this->assertIsArray($result);
        // Add additional assertions as needed
    }

    public function testReportSalesById()
    {
        // Set up any necessary data for the test
        // ...

        $kendaraan_id = Str::random(10);

        PenjualanModel::where("kendaraan_id", $kendaraan_id)->delete();

        // Create test data in the database for the Penjualan model
        $penjualan = PenjualanModel::factory()->create([
            'type_kendaraan' => 'type',
            'kendaraan_id' => $kendaraan_id,
            // Set other necessary attributes
        ]);

        // Create an instance of the repository
        $repository = new PenjualanRepository();

        // Call the method being tested
        $result = $repository->reportSalesById('type', $kendaraan_id);

        // Perform assertions on the result
        $this->assertCount(1, $result);
        $this->assertEquals($penjualan->id, $result->first()->id);
        // Add additional assertions as needed
    }
}
