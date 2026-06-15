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
            $table->string('place_1st_sector')->nullable(); // 'public' or 'school'
            $table->string('place_2nd_sector')->nullable();
            $table->string('place_3rd_sector')->nullable();
            $table->string('place_1st_institute')->nullable();
            $table->string('place_2nd_institute')->nullable();
            $table->string('place_3rd_institute')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('national_productivity_competitions', function (Blueprint $table) {
            $table->dropColumn([
                'place_1st_sector',
                'place_2nd_sector',
                'place_3rd_sector',
                'place_1st_institute',
                'place_2nd_institute',
                'place_3rd_institute',
            ]);
        });
    }
};
