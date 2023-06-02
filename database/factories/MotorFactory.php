<?php

namespace Database\Factories;

use App\Models\Motor;
use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jenssegers\Mongodb\Eloquent\Model;

class MotorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Motor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "mesin" => $this->faker->numberBetween(1000, 5000),
            "tipe_suspensi" => $this->faker->randomElement(["Teleskopik", "Upside Down", "Gas", "Oli"]),
            'tipe_transmisi' => $this->faker->randomElement(["Manual", "Otomatis"]),
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
        return $this->afterCreating(function (Motor $motor) {
            $kendaraan = Kendaraan::create([
                'tahun' => $this->faker->year,
                'warna' => $this->faker->colorName,
                'harga' => $this->faker->numberBetween(1000000, 10000000),
            ]);

            $motor->kendaraan_id = $kendaraan->id;
            $motor->save();
        });
    }
}
