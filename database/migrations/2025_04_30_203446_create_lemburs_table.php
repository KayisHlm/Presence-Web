<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLembursTable extends Migration
{
    public function up(): void
    {
        Schema::create('lemburs', function (Blueprint $table) {
            $table->string('user_id');
            $table->date('tanggal');
            $table->integer('jam_lembur');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Set primary key gabungan
            $table->primary(['user_id', 'tanggal']);

            // Foreign key
            $table->foreign('user_id')
                ->references('id')
                ->on('user_login')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lemburs');
    }
}
