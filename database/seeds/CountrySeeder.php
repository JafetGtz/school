<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['name' => 'Argentina', 'code' => 'AR'],
            ['name' => 'Bolivia', 'code' => 'BO'],
            ['name' => 'Chile', 'code' => 'CL'],
            ['name' => 'Colombia', 'code' => 'CO'],
            ['name' => 'Ecuador', 'code' => 'EC'],
            ['name' => 'México', 'code' => 'MX'],
            ['name' => 'Perú', 'code' => 'PE'],
            ['name' => 'España', 'code' => 'ES'],
            ['name' => 'Venezuela', 'code' => 'VE'],
        ]);
    }
}
