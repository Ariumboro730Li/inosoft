<?php

namespace Database\Factories;

use App\Models\Mobil;
use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jenssegers\Mongodb\Eloquent\Model;

class MobilFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mobil::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "mesin" => $this->faker->numberBetween(1000, 5000),
            "kapasitas" => $this->faker->numberBetween(2, 8),
            "tipe" => $this->faker->randomElement(["SUV", "MPV", "Sedan", "Hatchback"]),
            "stok" => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * Set the values of Kendaraan and associate it with the Mobil entity.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function configure()
    {
        return $this->afterCreating(function (Mobil $mobil) {
            $kendaraan = Kendaraan::create([
                'tahun' => $this->faker->year,
                'warna' => $this->faker->colorName,
                'harga' => $this->faker->numberBetween(1000000, 10000000),
            ]);

            $mobil->kendaraan_id = $kendaraan->id;
            $mobil->save();
        });
    }
}

