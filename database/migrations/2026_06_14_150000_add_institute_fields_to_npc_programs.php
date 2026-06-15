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
            $table->string('public_place_1st_institute')->nullable();
            $table->string('public_place_2nd_institute')->nullable();
            $table->string('public_place_3rd_institute')->nullable();
            $table->string('school_place_1st_institute')->nullable();
            $table->string('school_place_2nd_institute')->nullable();
            $table->string('school_place_3rd_institute')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('national_productivity_competitions', function (Blueprint $table) {
            $table->dropColumn([
                'public_place_1st_institute',
                'public_place_2nd_institute',
                'public_place_3rd_institute',
                'school_place_1st_institute',
                'school_place_2nd_institute',
                'school_place_3rd_institute',
            ]);
        });
    }
};
