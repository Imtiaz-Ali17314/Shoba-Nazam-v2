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
        Schema::create('discipline_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('madrasa_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('incident_type_id');
            $table->text('detail')->nullable();
            $table->date('date');
            $table->timestamps();

            // Foreign keys
            $table->foreign('madrasa_id')->references('id')->on('madrasas')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('incident_type_id')->references('id')->on('incident_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discipline_records');
    }
};