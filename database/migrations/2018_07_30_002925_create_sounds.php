<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSounds extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('sounds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->integer('word_id', false, true)->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('sounds');
    }
}
