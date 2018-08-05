<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        DB::table('words')->insert([
            ['word' => 'tree'],
            ['word' => 'table'],
            ['word' => 'water'],
            ['word' => 'glass'],
            ['word' => 'phone'],
        ]);
    }
}
