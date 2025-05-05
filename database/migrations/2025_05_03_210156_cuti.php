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
        Schema::create('cutis', function (Blueprint $table) {
            $table->string('user_id'); // Foreign key
            $table->enum('jenis_cuti', ['cuti_tahunan', 'cuti_sakit', 'cuti_melahirkan','cuti_penting'])->default('cuti_tahunan');
            $table->string('tipe_pengajuan');
            $table->date('tanggal');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Tambahan
            $table->timestamps();
        
            $table->primary(['user_id','jenis_cuti', 'tanggal']); // Primary key gabungan
        
            $table->foreign('user_id')
                  ->references('id')
                  ->on('user_login') // Pastikan nama tabel benar
                  ->onDelete('cascade');
        });
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
