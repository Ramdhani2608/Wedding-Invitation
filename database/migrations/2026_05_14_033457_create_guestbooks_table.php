<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {

            $table->id('id_tamu');

            $table->uuid('uuid')->unique();

            $table->string('nama_tamu');
            $table->string('no_hp')->nullable();

            $table->text('alamat')->nullable();

            $table->text('ucapan');

            $table->string('keterangan')
                ->nullable()
                ->default('belum_konfirmasi');

            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
