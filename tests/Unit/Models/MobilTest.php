<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Mobil;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;


class MobilTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        // Refresh MongoDB collections
        $this->refreshMongoCollections();
    }

    protected function refreshMongoCollections()
    {
        // Drop the existing collection
        Schema::dropIfExists('mobils');

        // Recreate the collection
        Schema::create('mobils', function (Blueprint $collection) {
            // Add fields to the collection as needed
        });
    }

    public function testVisibleAttributes()
    {
        // Create a new Kendaraan instance
        $mobil = new Mobil();

        // Retrieve the visible attributes
        $visibleAttributes = $mobil->getVisible();

        // Perform assertions
        $expectedAttributes =  ['_id', 'mesin', 'kapasitas', 'tipe', 'stok', 'kendaraan'];
        $this->assertEquals($expectedAttributes, $visibleAttributes);
    }

    public function testKendaraanRelationship()
    {
        Kendaraan::truncate();
        Mobil::truncate();

        $mobil = Mobil::factory()->create();

        $kendaraan = Kendaraan::where("_id", $mobil->kendaraan->id)->first();

        // Retrieve the related Kendaraan record
        $relatedKendaraan = $mobil->kendaraan;

        // Perform assertions
        $this->assertInstanceOf(Kendaraan::class, $relatedKendaraan);
        $this->assertEquals($kendaraan->_id, $relatedKendaraan->id);
        // Add additional assertions as needed
    }
}
