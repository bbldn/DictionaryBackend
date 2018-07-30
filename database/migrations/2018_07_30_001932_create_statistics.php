<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatistics extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->integer('correctly', false, true)->default(0);

            /** @noinspection PhpUndefinedMethodInspection */
            $table->integer('word_id', false, true)->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
}
