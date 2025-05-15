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
            $table->dropForeign('order_items_menu_id_foreign');

            $table->foreignId('menu_id')->change()->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('order_items', function (Blueprint $table) {
                if (Schema::hasColumn('order_items', 'menu_id')) {
                    $table->dropForeign('order_items_menu_id_foreign');
                }

                $table->foreignId('menu_id')->change()->nullable()->constrained();
            });
        } catch (Exception $exception) {
            \Illuminate\Support\Facades\Log::error($exception);
        }
    }
};
