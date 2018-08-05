<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaticSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        DB::table('statistics')->insert([
            ['correctly' => 0, 'word_id' => 1],
        ]);
    }
}
