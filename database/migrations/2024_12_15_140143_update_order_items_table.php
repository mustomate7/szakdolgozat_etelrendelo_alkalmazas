<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('quantity')->after('menu_id');
            $table->string('name')->after('menu_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('order_items', 'quantity') && Schema::hasColumn('order_items', 'name')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('quantity');
                $table->dropColumn('name');
            });
        }
    }
};
