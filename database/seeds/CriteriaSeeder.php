<?php

use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('criterias')->insert([
            ['name' => 'Paciencia en la enseñanza'],
            ['name' => 'Escucha al alumno'],
            ['name' => 'Uso adecuado de las tecnología'],
        ]);
    }
}
