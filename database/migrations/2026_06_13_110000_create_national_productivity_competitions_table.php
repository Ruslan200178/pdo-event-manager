<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('national_productivity_competitions', function (Blueprint $table) {
            $table->id();
            $table->string('received_allocation');
            $table->string('vote_number');
            $table->decimal('amount', 12, 2);
            $table->date('conducted_date');
            $table->string('place');
            $table->integer('participants_public')->default(0);
            $table->integer('participants_school')->default(0);
            $table->integer('participants_private')->default(0);
            $table->integer('public_applications_count')->default(0);
            $table->integer('public_selected_count')->default(0);
            $table->integer('place_1st_count')->default(0);
            $table->integer('place_2nd_count')->default(0);
            $table->integer('place_3rd_count')->default(0);
            $table->integer('speech_comm_count')->default(0);
            $table->integer('app_comm_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('national_productivity_competitions');
    }
};
