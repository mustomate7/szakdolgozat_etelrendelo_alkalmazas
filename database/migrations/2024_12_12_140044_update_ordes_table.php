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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('stripe_payment_id')->after('user_id');
            $table->string('shipping_address')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('orders', 'stripe_payment_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('stripe_payment_id');
                $table->dropColumn('shipping_address');
            });
        }
    }
};
