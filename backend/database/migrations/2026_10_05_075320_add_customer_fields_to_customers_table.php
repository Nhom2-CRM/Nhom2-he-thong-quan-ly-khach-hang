<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('name', 255)
                ->after('id');

            $table->string('tax_code', 50)
                ->nullable()
                ->unique()
                ->after('name');

            $table->foreignId('owner_id')
                ->nullable()
                ->after('tax_code')
                ->constrained('users')
                ->nullOnDelete();

            $table->boolean('is_active')
                ->default(true)
                ->after('owner_id');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropUnique(['tax_code']);
            $table->dropColumn([
                'name',
                'tax_code',
                'owner_id',
                'is_active',
            ]);
        });
    }
};