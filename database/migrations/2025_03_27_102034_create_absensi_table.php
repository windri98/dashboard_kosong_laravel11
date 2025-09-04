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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->string('id_card_id')->constrained('id_card')->onDelete('cascade');
            $table->string('nama_id');
            $table->string('jabatan_id');
            $table->date('tanggal'); // Tanggal absensi
            $table->string('shift_id')->constrained('nama_shift')->onDelete('cascade');
            $table->time('jam_masuk')->nullable(); 
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('hadir');
            $table->string('lokasi')->nullable(); // Lokasi absensi (misalnya GPS)
            $table->string('keterangan')->nullable(); // Catatan tambahan
            $table->string('foto_selfie')->nullable(); // Jika ada fitur selfie absensi
            $table->string('device')->nullable(); // Jenis perangkat absensi
            $table->boolean('is_late')->default(false); // Menandakan keterlambatan
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
