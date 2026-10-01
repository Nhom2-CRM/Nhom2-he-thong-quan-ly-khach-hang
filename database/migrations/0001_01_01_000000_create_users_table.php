<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id(); $table->string('name'); $table->string('email')->unique(); $table->timestamp('email_verified_at')->nullable();
                $table->string('password'); $table->string('business_group')->nullable(); $table->string('role')->default('sales');
                $table->enum('status',['pending','active','inactive'])->default('pending'); $table->timestamp('activated_at')->nullable();
                $table->rememberToken(); $table->timestamps();
            });
        }
    }
    public function down(): void { Schema::dropIfExists('users'); }
};
