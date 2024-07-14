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
        Schema::create('curriculum', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('customer_info')->nullable();
            $table->enum('status', \App\Enums\CurriculumStatus::toArray());

            $table->foreignId('customer_id')->nullable(false)->constrained('users');
            #$table->foreignId('assembler_id')->nullable()->constrained('users');
            $table->foreignId('reviewer_id')->nullable()->constrained('users');
        });

        Schema::create('curriculum_version', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('content');

            $table->foreignId('curriculum_id')->nullable(false)->constrained('curriculum');
            $table->foreignId('editor_id')->nullable(false)->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum');
    }
};
