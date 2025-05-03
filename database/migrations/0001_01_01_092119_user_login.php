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
        Schema::create('user_login', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('nama');
            $table->string('email');
            $table->string('password');
            $table->string('posisi');
            $table->string('role');
            $table->integer('gaji');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_login');
    }
};
