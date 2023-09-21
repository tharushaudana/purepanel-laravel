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
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('center_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->string('whatsapp')->nullable();
            $table->timestamps();
            $table->primary('id');
            $table->foreign('batch_id')
                ->references('id')
                ->on('batches')
                ->onDelete('cascade');
            $table->foreign('center_id')
                ->references('id')
                ->on('centers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
