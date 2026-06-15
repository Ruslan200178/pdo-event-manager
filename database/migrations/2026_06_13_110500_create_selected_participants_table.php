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
        Schema::create('selected_participants', function (Blueprint $table) {
            $table->id();
            $table->string('proyouth_type'); // 'video' or 'proposal'
            $table->unsignedBigInteger('proyouth_id');
            $table->integer('marks')->default(0);
            $table->boolean('is_winner')->default(false);
            $table->timestamps();

            // Add index for polymorphic queries
            $table->index(['proyouth_type', 'proyouth_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('selected_participants');
    }
};
