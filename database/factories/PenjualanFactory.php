<?php

namespace Database\Factories;

use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenjualanFactory extends Factory
{
    protected $model = Penjualan::class;

    public function definition()
    {
        return [
            'type_kendaraan' => $this->faker->word,
            'kendaraan_id' => $this->faker->randomNumber(),
        ];
    }
}
