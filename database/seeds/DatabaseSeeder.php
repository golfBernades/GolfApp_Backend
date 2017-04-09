<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Deshabilita llaves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Llena las tablas con los seeders
        $this->seedTables();
        // Habilita las llaves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function seedTables()
    {
        $this->call(JugadorTableSeeder::class);
        $this->call(CampoTableSeeder::class);
        $this->call(ApuestaTableSeeder::class);
    }
}
