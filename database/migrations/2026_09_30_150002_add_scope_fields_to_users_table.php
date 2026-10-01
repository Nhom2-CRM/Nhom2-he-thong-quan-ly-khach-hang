<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::table('users', function (Blueprint $table) { $table->string('role')->default('SALES_REP'); $table->string('data_scope')->default('MINE'); $table->foreignId('business_group_id')->nullable()->constrained()->nullOnDelete(); }); }
    public function down(): void { Schema::table('users', function (Blueprint $table) { $table->dropConstrainedForeignId('business_group_id'); $table->dropColumn(['role','data_scope']); }); }
};
