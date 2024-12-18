<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Metals;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       Equipment::factory(10)->create();
       Metals::factory(10)->create();
    }
}
