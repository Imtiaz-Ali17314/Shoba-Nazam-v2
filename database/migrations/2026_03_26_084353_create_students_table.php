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
            $table->id();
            $table->unsignedBigInteger('madrasa_id');
            $table->string('sname');
            $table->string('fathername');
            $table->string('code');
            $table->string('class');
            $table->timestamps();

            // Foreign key
            $table->foreign('madrasa_id')->references('id')->on('madrasas')->onDelete('cascade');

            // Unique constraint on madrasa_id + code
            $table->unique(['madrasa_id', 'code']);
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