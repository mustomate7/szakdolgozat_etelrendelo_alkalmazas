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
        Schema::table('images', function (Blueprint $table) {
            try {
                if (Schema::hasColumn('images', 'food_id')) {
                    $table->dropForeign('images_food_id_foreign');
                    $table->dropColumn('food_id');
                }
            } catch (Exception $exception) {
                \Illuminate\Support\Facades\Log::error($exception);
            }

            $table->string("imageable_type")->after('id');

            $table->unsignedBigInteger("imageable_id")->after('imageable_type');

            $table->index(["imageable_type", "imageable_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            if(Schema::hasColumn('images','imageable_id')) {
                $table->dropColumn('imageable_id');
            }
            if (Schema::hasColumn('images','imageable_type')) {
                $table->dropColumn('imageable_type');
            }
            $table->foreignId('food_id')->after('id')->constrained('foods');
        });
    }
};
