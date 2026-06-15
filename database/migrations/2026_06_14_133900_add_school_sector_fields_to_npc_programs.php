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
            $table->integer('school_applications_count')->default(0);
            $table->integer('school_selected_count')->default(0);
            $table->integer('school_place_1st_count')->default(0);
            $table->integer('school_place_2nd_count')->default(0);
            $table->integer('school_place_3rd_count')->default(0);
            $table->integer('school_special_commentation_count')->default(0);
            $table->integer('school_commentation_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('national_productivity_competitions', function (Blueprint $table) {
            $table->dropColumn([
                'school_applications_count',
                'school_selected_count',
                'school_place_1st_count',
                'school_place_2nd_count',
                'school_place_3rd_count',
                'school_special_commentation_count',
                'school_commentation_count',
            ]);
        });
    }
};
