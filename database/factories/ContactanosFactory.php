<?php

namespace Database\Factories;

use App\Models\Contactanos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contactanos>
 */
class ContactanosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Contactanos::class;
    public function definition()
    {
        return [
            //
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'correo' => $this->faker->unique()->safeEmail(),
            'puesto'=> $this->faker->name(),
            'contactanos' => '09' . $this->faker->randomNumber(8),
        ];
    }
}
