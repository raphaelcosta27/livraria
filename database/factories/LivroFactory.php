<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LivroFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titulo'          => $this->faker->sentence(2),
            'editora'         => $this->faker->company,
            'edicao'          => $this->faker->numberBetween(1, 5),
            'ano_publicacao'  => (string)$this->faker->numberBetween(1950, date('Y') - 1),
            'valor'           => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
