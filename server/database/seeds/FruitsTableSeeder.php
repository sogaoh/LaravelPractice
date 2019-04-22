<?php

use Illuminate\Database\Seeder;

class FruitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fruits = [
            ['name' => 'りんご', 'price' => 100 ],  // 1
            ['name' => 'バナナ', 'price' => 200 ],  // 2
            ['name' => 'みかん', 'price' => 50 ],   // 3
        ];
        foreach ($fruits as $fruit) {
            DB::table('fruits')->insert($fruit);
        }
    }
}
