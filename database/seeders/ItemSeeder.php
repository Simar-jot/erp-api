<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $names = ['pen', 'notebook', 'pencil', 'colors'];
        $units = ['pc', 'box'];

        foreach (range(1, 25) as $index) {
            $name = $names[array_rand($names)];
            $unit = $units[array_rand($units)];
            $sku = strtoupper(substr($name, 0, 3)) . '-' . $faker->unique()->randomNumber(3);

            DB::table('items')->insert([
                'name' => $name,
                'sku' => $sku,
                'unit' => $unit,
                'price' => $faker->randomFloat(2, 5, 100),
                'stock_quantity' => $faker->numberBetween(0, 100),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
