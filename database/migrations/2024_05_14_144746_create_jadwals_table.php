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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->string('id_moulding')->unique();
            $table->date('tanggal');
            $table->string('type_moulding');
            $table->string('durasi');
            $table->date('mulai_tanggal');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('keterangan', ['Selesai', 'Proses', 'Tidak Selesai'])->default("Tidak Selesai");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
