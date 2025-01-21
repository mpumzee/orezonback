<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Minerals',
            'description' => 'just a mineral',
        ];
    }

    public function minerals()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Minerals';
            $record['description'] = 'just a mineral';
        });
    }

    public function drillingEquipment()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Drilling Equipment';
            $record['description'] = 'just equipment';
        });
    }
    public function loadingEquipment()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Loading and Hauling Equipment';
            $record['description'] = 'just a loading and hauling Equipment';
        });
    }

    public function crushingEquipment()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Crushing and Grinding Equipment';
            $record['description'] = 'just a crushing and grinding Equipment';
        });
    }
    public function separationEquipment()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Separation and Concentration Equipment';
            $record['description'] = 'just a separation and concentration Equipment';
        });
    }
    public function undergroundEquipment()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Underground Mining Equipment';
            $record['description'] = 'just a underground mining Equipment';
        });
    }
    public function safetyEquipment()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Safety Equipment';
            $record['description'] = 'just a safety equipment';
        });
    }
    public function miscellaneousEquipment()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Miscellaneous Equipment';
            $record['description'] = 'just a miscellaneous Equipment';
        });
    }
    public function sparesEquipment()
    {
        return $this->afterMaking(function ($record) {
            $record['name'] = 'Spares Equipment';
            $record['description'] = 'just a spares Equipment';
        });
    }
}
