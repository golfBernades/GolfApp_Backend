<?php

use Illuminate\Database\Seeder;

class CampoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campo')->truncate();

        DB::table('campo')->insert(array([
            'nombre' => 'Bernardes',
            'par_hoyo_1' => 5,
            'par_hoyo_2' => 4,
            'par_hoyo_3' => 3,
            'par_hoyo_4' => 4,
            'par_hoyo_5' => 3,
            'par_hoyo_6' => 4,
            'par_hoyo_7' => 4,
            'par_hoyo_8' => 4,
            'par_hoyo_9' => 5,
            'par_hoyo_10' => 5,
            'par_hoyo_11' => 4,
            'par_hoyo_12' => 3,
            'par_hoyo_13' => 4,
            'par_hoyo_14' => 3,
            'par_hoyo_15' => 4,
            'par_hoyo_16' => 4,
            'par_hoyo_17' => 4,
            'par_hoyo_18' => 5,
            'ventaja_hoyo_1' => 3,
            'ventaja_hoyo_2' => 9,
            'ventaja_hoyo_3' => 5,
            'ventaja_hoyo_4' => 11,
            'ventaja_hoyo_5' => 15,
            'ventaja_hoyo_6' => 7,
            'ventaja_hoyo_7' => 1,
            'ventaja_hoyo_8' => 13,
            'ventaja_hoyo_9' => 17,
            'ventaja_hoyo_10' => 4,
            'ventaja_hoyo_11' => 10,
            'ventaja_hoyo_12' => 12,
            'ventaja_hoyo_13' => 8,
            'ventaja_hoyo_14' => 16,
            'ventaja_hoyo_15' => 6,
            'ventaja_hoyo_16' => 2,
            'ventaja_hoyo_17' => 14,
            'ventaja_hoyo_18' => 18,
        ], [
            'nombre' => 'AguasCampo',
            'par_hoyo_1' => 6,
            'par_hoyo_2' => 5,
            'par_hoyo_3' => 3,
            'par_hoyo_4' => 6,
            'par_hoyo_5' => 7,
            'par_hoyo_6' => 3,
            'par_hoyo_7' => 5,
            'par_hoyo_8' => 4,
            'par_hoyo_9' => 5,
            'par_hoyo_10' => 4,
            'par_hoyo_11' => 4,
            'par_hoyo_12' => 4,
            'par_hoyo_13' => 4,
            'par_hoyo_14' => 5,
            'par_hoyo_15' => 6,
            'par_hoyo_16' => 3,
            'par_hoyo_17' => 5,
            'par_hoyo_18' => 4,
            'ventaja_hoyo_1' => 3,
            'ventaja_hoyo_2' => 9,
            'ventaja_hoyo_3' => 5,
            'ventaja_hoyo_4' => 11,
            'ventaja_hoyo_5' => 15,
            'ventaja_hoyo_6' => 7,
            'ventaja_hoyo_7' => 1,
            'ventaja_hoyo_8' => 13,
            'ventaja_hoyo_9' => 17,
            'ventaja_hoyo_10' => 4,
            'ventaja_hoyo_11' => 10,
            'ventaja_hoyo_12' => 12,
            'ventaja_hoyo_13' => 8,
            'ventaja_hoyo_14' => 16,
            'ventaja_hoyo_15' => 6,
            'ventaja_hoyo_16' => 2,
            'ventaja_hoyo_17' => 14,
            'ventaja_hoyo_18' => 18,
        ]));
    }
}
