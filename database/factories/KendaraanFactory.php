<?php

namespace Database\Factories;

use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KendaraanFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kendaraan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            "tahun" => $this->faker->year(),
            "warna" => $this->faker->colorName(),
            "harga" => $this->faker->numberBetween(10000000, 100000000),
        ];
    }
}
