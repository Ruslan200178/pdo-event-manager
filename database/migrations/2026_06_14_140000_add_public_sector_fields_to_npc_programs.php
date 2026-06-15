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
        Schema::table('national_productivity_competitions', function (Blueprint $table) {
            // Add new columns for public sector comment counts
            $table->integer('special_commentation_count')->default(0);
            $table->integer('commentation_count')->default(0);
            // Remove old columns if they exist
            if (Schema::hasColumn('national_productivity_competitions', 'speech_comm_count')) {
                $table->dropColumn('speech_comm_count');
            }
            if (Schema::hasColumn('national_productivity_competitions', 'app_comm_count')) {
                $table->dropColumn('app_comm_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('national_productivity_competitions', function (Blueprint $table) {
            // Re‑add old columns
            $table->integer('speech_comm_count')->default(0);
            $table->integer('app_comm_count')->default(0);
            // Remove the new columns
            $table->dropColumn(['special_commentation_count', 'commentation_count']);
        });
    }
};
