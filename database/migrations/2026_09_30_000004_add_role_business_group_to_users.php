<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::table('users', function(Blueprint $table){ $table->string('role')->default('Nhân viên kinh doanh')->after('password'); $table->foreignId('business_group_id')->nullable()->after('role')->constrained('business_groups')->nullOnDelete(); }); }
 public function down(): void { Schema::table('users', function(Blueprint $table){ $table->dropForeign(['business_group_id']); $table->dropColumn(['role','business_group_id']); }); }
};
