<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('categories')->insert([
        ['name' => 'First'],
        ['name' => 'Second'],
        ['name' => 'Third'],
        ['name' => 'Fourth']
      ]);

      DB::table('subcategories')->insert([
        [
          'category_id' => '1',
          'name' => '1'
        ],
        [
          'category_id' => '2',
          'name' => '2'
        ],
        [
          'category_id' => '3',
          'name' => '3'
        ],
        [
          'category_id' => '4',
          'name' => '4'
        ],
      ]);
    }
}
