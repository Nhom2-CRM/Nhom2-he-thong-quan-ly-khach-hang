<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('due_date');
            $table->string('priority')->default('medium');
            $table->string('status')->default('pending');
            $table->text('postpone_reason')->nullable();
            
            $table->foreignId('assigned_to_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('created_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('opportunity_id')->nullable()->constrained('opportunities')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};