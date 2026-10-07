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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('floor_price', 15, 2)
                ->nullable()
                ->after('list_price');

            $table->decimal('cost_price', 15, 2)
                ->nullable()
                ->after('floor_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'floor_price',
                'cost_price',
            ]);
        });
    }
};