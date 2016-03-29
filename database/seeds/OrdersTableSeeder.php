<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{

    public function run()
    {

//        for ($i = 0; $i <= 10000; $i++) {
//
//            $orderId = DB::table('orders')->insertGetId([
//                'customer_id' => 2,
//                'total' => rand(50, 200),
//                'status' => 1,
//                'created_at' => Carbon::now(),
//            ]);
//
//
//            for ($j = 1; $j <= 3; $j++) {
//
//                DB::table('orders_items')->insert([
//                    'order_id' => $orderId,
//                    'product_id' => 1,
//                    'name' => 'Alamos',
//                    'quantity' => rand(1, 10),
//                ]);
//
//            }
//
//
//        }

    }
}