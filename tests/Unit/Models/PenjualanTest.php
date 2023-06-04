<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Penjualan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;

class PenjualanTest extends TestCase
{
    // use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Refresh MongoDB collections
        $this->refreshMongoCollections();
    }

    protected function refreshMongoCollections()
    {
        // Drop the existing collection
        Schema::dropIfExists('penjualans');

        // Recreate the collection
        Schema::create('penjualans', function (Blueprint $collection) {
            // Add fields to the collection as needed
        });
    }

    public function testVisibleAttributes()
    {
        // Create a new Penjualan instance
        $penjualan = new Penjualan();

        // Retrieve the visible attributes
        $visibleAttributes = $penjualan->getVisible();

        // Perform assertions
        $expectedAttributes = ['_id', 'kendaraan_id', 'nama', 'jumlah', 'tanggal', 'alamat', 'type_kendaraan'];
        $this->assertEquals($expectedAttributes, $visibleAttributes);
    }

    public function testCasting()
    {
        // Create a new Penjualan instance
        $penjualan = new Penjualan();

        // Retrieve the casting
        $casting = $penjualan->getCasts();

        // Perform assertions
        $expectedCasts = [
            'tanggal' => 'date:Y-m-d H:i:s',
        ];
        $this->assertEquals($expectedCasts, $casting);
    }

    public function testSerializeDate()
    {
        // Create a new Penjualan instance
        $penjualan = new Penjualan();

        // Create a Carbon instance for testing
        $dateTime = Carbon::create(2023, 6, 5, 12, 0, 0, 'UTC');

        // Call the serializeDate method
        $serializedDate = $penjualan->serializeDate($dateTime);

        // Perform assertions
        $this->assertEquals('2023-06-05 19:00:00', $serializedDate);
    }
}
