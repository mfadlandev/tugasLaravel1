<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('petanis', function (Blueprint $table) {
            // primary Key
            $table->id('id_penjual');

            // foreign Key tabel kelompok tani
            $table->foreignId('id_kelompok_tani');

            $table->string('nama');
            $table->string('nik', 16);
            $table->string('alamat', 100);
            $table->string('telp');

            // default length 45
            $table->string('foto', 100);
            $table->char('status');

            // default created date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petanis');
    }
};