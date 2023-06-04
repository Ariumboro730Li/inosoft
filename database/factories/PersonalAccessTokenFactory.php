<?php

namespace Database\Factories;

use App\Models\PersonalAccessToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalAccessTokenFactory extends Factory
{
    protected $model = PersonalAccessToken::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'token' => $this->faker->uuid,
            'abilities' => [],
        ];
    }
}
