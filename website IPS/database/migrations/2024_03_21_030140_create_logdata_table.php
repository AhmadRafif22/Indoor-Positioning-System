<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logdata', function (Blueprint $table) {
            $table->id();
            $table->string('mac');
            $table->string('data');
            $table->bigInteger('wek');
            $table->bigInteger('wsk');
            $table->string('predicted_room');
            $table->bigInteger('wet');
            $table->string('waktu_simpan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logdata');
    }
};
