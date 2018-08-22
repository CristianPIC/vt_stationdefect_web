<?php

use Illuminate\Database\Seeder;

class ColourTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\colour::class,30)->create();
    }
}
