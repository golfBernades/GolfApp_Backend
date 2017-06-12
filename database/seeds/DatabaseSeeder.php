<?php

use Illuminate\Database\Seeder;

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
        $this->call(CampoTableSeeder::class);
        $this->call(ClaveConsultaPartidoTableSeeder::class);
        $this->call(ClaveEdicionPartidoTableSeeder::class);
        $this->call(PartidoTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);
    }
}
