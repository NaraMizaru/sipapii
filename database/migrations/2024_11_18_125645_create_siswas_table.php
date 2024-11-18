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
        Schema::create('siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->string('nis')->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);

            $table->uuid('kelas_id');
            $table->foreign('kelas_id')->references('id')->on('kelas')->cascadeOnDelete();

            $table->uuid('tahun_ajar_id');
            $table->foreign('tahun_ajar_id')->references('id')->on('tahun_ajars')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
