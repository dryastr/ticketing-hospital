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
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_antrian')->unique();
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('poliklinik_id')->constrained('poliklinik')->onDelete('cascade');
            $table->enum('status', ['waiting', 'checking', 'done'])->default('waiting');
            $table->timestamp('waktu_pendaftaran')->useCurrent();
            $table->timestamp('waktu_periksa')->nullable();
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
