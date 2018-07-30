<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWords extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->increments('id');
            $table->text('word');
            /** @noinspection PhpUndefinedMethodInspection */
            $table->tinyInteger('archive', false, true)->default(0);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
}
