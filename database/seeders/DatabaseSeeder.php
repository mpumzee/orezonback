<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\Metals;
use App\Models\SubCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();
       Equipment::factory(10)->create();
       Metals::factory(10)->create();
       Category::factory(1)->minerals()->create();
        Category::factory(1)->drillingEquipment()->create();
        Category::factory(1)->crushingEquipment()->create();
        Category::factory(1)->loadingEquipment()->create();
        Category::factory(1)->separationEquipment()->create();
        Category::factory(1)->undergroundEquipment()->create();
        Category::factory(1)->safetyEquipment()->create();
        Category::factory(1)->miscellaneousEquipment()->create();
        Category::factory(1)->sparesEquipment()->create();
        SubCategory::factory(1)->preciousMinerals()->create();
        SubCategory::factory(1)->industrialMinerals()->create();
        SubCategory::factory(1)->energyMinerals()->create();
        SubCategory::factory(1)->metallicMinerals()->create();
        SubCategory::factory(1)->nonMetallicMinerals()->create();
        SubCategory::factory(1)->drillRigs()->create();
        SubCategory::factory(1)->rotaryDrills()->create();
        SubCategory::factory(1)->loaders()->create();
        SubCategory::factory(1)->jawCrushers()->create();
        SubCategory::factory(1)->floatationCells()->create();
        SubCategory::factory(1)->jumbos()->create();
        SubCategory::factory(1)->hardHats()->create();
        SubCategory::factory(1)->generators()->create();
        SubCategory::factory(1)->pneumaticDrills()->create();
        SubCategory::factory(1)->jackHammers()->create();
        SubCategory::factory(1)->haulTrucks()->create();
        SubCategory::factory(1)->conveyorBelts()->create();
        SubCategory::factory(1)->skidSteerLoaders()->create();
        SubCategory::factory(1)->coneCrushers()->create();
        SubCategory::factory(1)->ballMills()->create();
        SubCategory::factory(1)->rodMills()->create();
    }
}
