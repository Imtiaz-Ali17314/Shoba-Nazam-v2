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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('madrasa_id');
            $table->unsignedBigInteger('user_id');
            $table->string('action'); // e.g., created, updated, deleted
            $table->string('model_type'); // e.g., App\Models\Student
            $table->unsignedBigInteger('model_id'); // ID of the model
            $table->json('changes')->nullable(); // Store changed fields as JSON
            $table->timestamps();

            // Foreign keys
            $table->foreign('madrasa_id')->references('id')->on('madrasas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};