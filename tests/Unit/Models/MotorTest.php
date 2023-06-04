<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Motor;
use App\Models\Kendaraan;

class MotorTest extends TestCase
{
    // use RefreshDatabase;

    public function testKendaraanRelationship()
    {
        Kendaraan::truncate();
        Motor::truncate();

        $motor = Motor::factory()->create();

        $kendaraan = Kendaraan::where("_id", $motor->kendaraan->id)->first();

        // Retrieve the related Kendaraan record
        $relatedKendaraan = $motor->kendaraan;

        // Perform assertions
        $this->assertInstanceOf(Kendaraan::class, $relatedKendaraan);
        $this->assertEquals($kendaraan->_id, $relatedKendaraan->id);
        // Add additional assertions as needed
    }
}
