<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranslationsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        DB::table('translations')->insert([
            ['translation' => 'дерево', 'word_id' => 1],
            ['translation' => 'стол', 'word_id' => 2],
            ['translation' => 'вода', 'word_id' => 3],
            ['translation' => 'стекло', 'word_id' => 4],
            ['translation' => 'телефон', 'word_id' => 5],
        ]);
    }
}
