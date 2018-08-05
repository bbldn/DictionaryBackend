<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->call(WordsSeeder::class);
        $this->call(TranslationsSeeder::class);
        $this->call(StaticSeeder::class);
    }
}
