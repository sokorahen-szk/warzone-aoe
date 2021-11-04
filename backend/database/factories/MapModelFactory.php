<?php

namespace Database\Factories;

use App\Models\MapModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MapModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_package_id' => 1,
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
        ];
    }

    public function setGamePackageId(int $id)
    {
        return $this->state(function (array $attributes) use ($id) {
            return [
                'game_package_id' => $id,
            ];
        });
    }
}
