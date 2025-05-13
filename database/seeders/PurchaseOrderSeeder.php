<?php

namespace Database\Seeders;

use App\Models\Item;
use Faker\Factory as Faker;
use App\Models\PurchaseOrder;
use Illuminate\Database\Seeder;
use App\Models\PurchaseOrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $itemIds = Item::pluck('id')->toArray();

        foreach (range(1, 10) as $i) {
            $purchaseOrder = PurchaseOrder::create([
                'vendor_name' => $faker->company,
                'date' => $faker->date(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            foreach (range(1, rand(1, 4)) as $j) {
                $itemId = $faker->randomElement($itemIds);
                $item = Item::find($itemId);

                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_id' => $itemId,
                    'quantity' => $faker->numberBetween(1, 20),
                    'price' => $item->price,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
