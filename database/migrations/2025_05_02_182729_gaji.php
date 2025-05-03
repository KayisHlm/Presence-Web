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
        Schema::create('gajis', function (Blueprint $table) {
            $table->string('user_id'); // Foreign key for user
            $table->integer('bonus');
            $table->integer('deduction');
            $table->date('tanggal');
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraint
            $table->foreign('user_id')
                ->references('id') // References the 'id' column in the 'users' table
                ->on('user_login') // Make sure the table name is 'users'
                ->onDelete('cascade'); // If a user is deleted, their related salary record is also deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
