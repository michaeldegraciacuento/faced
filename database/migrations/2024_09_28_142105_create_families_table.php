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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('household_id');
            $table->string('name');
            $table->string('relation');
            $table->date('birthdate');
            $table->integer('age');
            $table->string('sex');
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->string('remarks')->nullable();
            $table->foreign('household_id')->references('id')->on('households')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
