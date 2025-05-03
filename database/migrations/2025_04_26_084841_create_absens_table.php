<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // Menggunakan unsignedBigInteger untuk relasi ke ID user
            $table->date('tanggal');
            $table->time('check_in')->nullable(); // Menambahkan kolom check_in
            $table->time('check_out')->nullable(); // Menambahkan kolom check_out
            $table->decimal('lokasi_latitude_in', 10, 7)->nullable();
            $table->decimal('lokasi_longitude_in', 10, 7)->nullable();
            $table->decimal('lokasi_latitude_out', 10, 7)->nullable();
            $table->decimal('lokasi_longitude_out', 10, 7)->nullable();
            $table->enum('status', ['Hadir', 'Izin', 'Sakit'])->default('Hadir');
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('user_login')
            ->onDelete('cascade');
        });
    
}
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
