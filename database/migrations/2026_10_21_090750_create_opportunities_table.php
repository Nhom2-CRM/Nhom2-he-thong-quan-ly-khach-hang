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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('team_id')->nullable();
            $table->string('name');
            $table->decimal('amount', 15, 2);
            $table->integer('probability')->default(0); // Xác suất %
            $table->date('expected_close_date');       // Kỳ dự kiến chốt
            $table->enum('status', ['in_progress', 'won', 'lost'])->default('in_progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};