<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Kendaraan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

class KendaraanTest extends TestCase
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
        Schema::dropIfExists('kendaraans');

        // Recreate the collection
        Schema::create('kendaraans', function (Blueprint $collection) {
            // Add fields to the collection as needed
        });
    }

    public function testVisibleAttributes()
    {
        // Create a new Kendaraan instance
        $kendaraan = new Kendaraan();

        // Retrieve the visible attributes
        $visibleAttributes = $kendaraan->getVisible();

        // Perform assertions
        $expectedAttributes = ['tahun', 'warna', 'harga'];
        $this->assertEquals($expectedAttributes, $visibleAttributes);
    }
}
