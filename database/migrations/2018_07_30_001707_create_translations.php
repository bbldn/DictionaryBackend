<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslations extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('translation');

            /** @noinspection PhpUndefinedMethodInspection */
            $table->integer('word_id', false, true)->nullable();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
}
