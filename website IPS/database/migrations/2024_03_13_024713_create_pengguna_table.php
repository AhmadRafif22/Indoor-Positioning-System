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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('perangkat_id')->nullable()->unique();

            $table->string('kode')->unique();
            $table->string('jabatan');

            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('perangkat_id')->references('id')->on('perangkats')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
};
