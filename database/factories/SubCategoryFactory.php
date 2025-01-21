<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => 1,
            'name' => 'Minerals',
            'description' => 'just a mineral',
        ];
    }

    public function preciousMinerals()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 1;
            $record['name'] = 'Precious Minerals';
            $record['description'] = 'Rare, naturally occurring metallic chemical elements of high economic value.';
        });
    }

    public function industrialMinerals()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 1;
            $record['name'] = 'Industrial Minerals';
            $record['description'] = 'A rock, a mineral or other naturally occurring material of economic value.';
        });
    }

    public function energyMinerals()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 1;
            $record['name'] = 'Energy Minerals';
            $record['description'] = 'Minerals that can be burned to release energy, such as coal and uranium.';
        });
    }

    public function metallicMinerals()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 1;
            $record['name'] = 'Metallic Minerals';
            $record['description'] = 'Minerals which contain one or more metallic elements in their raw form.';
        });
    }

    public function nonMetallicMinerals()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 1;
            $record['name'] = 'Non-Metallic Minerals';
            $record['description'] = 'Composed of chemical elements that dont have the properties of any metals.';
        });
    }
    public function drillRigs()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 2;
            $record['name'] = 'Drill Rigs';
            $record['description'] = 'Equipment used to drill holes in the ground for such activities as prospecting.';
        });
    }
    public function rotaryDrills()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 2;
            $record['name'] = 'Rotary Drills';
            $record['description'] = 'Equipment used to drill holes in the ground for such activities as prospecting.';
        });
    }
    public function loaders()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 3;
            $record['name'] = 'Loaders';
            $record['description'] = 'Equipment used to remove overburden and waste rocks from the mine site.';
        });
    }
    public function jawCrushers()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 4;
            $record['name'] = 'Jaw Crushers';
            $record['description'] = 'Equipment used in the liberation and reduction of the size of the ore.';
        });
    }
    public function floatationCells()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 5;
            $record['name'] = 'Floatation Cells';
            $record['description'] = 'Equipment for separating commercially valuable minerals from their ores.';
        });
    }
    public function jumbos()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 6;
            $record['name'] = 'Jumbos';
            $record['description'] = 'A variety of subsurface mining techniques used to extract hard minerals.';
        });
    }
    public function hardHats()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 7;
            $record['name'] = 'Hard Hats';
            $record['description'] = 'Collection of tools and protective gear that miners use to protect themselves.';
        });
    }
    public function generators()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 8;
            $record['name'] = 'Generators';
            $record['description'] = 'Their availability is important for ensuring high output.';
        });
    }
    public function pneumaticDrills()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 2;
            $record['name'] = 'Pneumatic Drills';
            $record['description'] = 'Handheld tools that uses compressed air to drill holes or break through hard surfaces.';
        });
    }
    public function jackHammers()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 2;
            $record['name'] = 'Jack Hammers';
            $record['description'] = 'Powerful tools that uses a chisel and either compressed air or an electric motor to break through hard materials like concrete or rock.';
        });
    }
    public function haulTrucks()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 3;
            $record['name'] = 'Haul Trucks';
            $record['description'] = 'Off-road, heavy-duty dump trucks specifically engineered for use in high-production mining and exceptionally demanding construction environments.';
        });
    }
    public function conveyorBelts()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 3;
            $record['name'] = 'Conveyor Belts';
            $record['description'] = 'Mechanical devices that moves goods and materials through a facility.';
        });
    }
    public function skidSteerLoaders()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 3;
            $record['name'] = 'Skid-Steer Loaders';
            $record['description'] = "Compact, versatile machines with wheels that's used for construction, landscaping, and agriculture.";
        });
    }
    public function coneCrushers()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 4;
            $record['name'] = 'Conec Crushers';
            $record['description'] = 'Machines that uses compression force to break large materials into smaller pieces, like sand, gravel, and rocks.';
        });
    }
    public function ballMills()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 4;
            $record['name'] = 'Ball Mills';
            $record['description'] = 'Machines that grinds materials into a fine powder using steel or rubber balls.';
        });
    }
    public function rodMills()
    {
        return $this->afterMaking(function ($record) {
            $record['category_id'] = 4;
            $record['name'] = 'Roda Mills';
            $record['description'] = 'Rod mills are used in an open circuit between crushing and the ball mill.';
        });
    }



}
