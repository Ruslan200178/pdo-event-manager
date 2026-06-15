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
        Schema::create('proyouth_video_competition', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nic_number');
            $table->string('address');
            $table->integer('age');
            $table->string('ds_division');
            $table->string('institute_school');
            $table->string('video_link')->nullable();
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
        Schema::dropIfExists('proyouth_video_competition');
    }
};
