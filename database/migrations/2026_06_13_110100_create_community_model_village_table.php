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
        Schema::create('community_model_village', function (Blueprint $table) {
            $table->id();
            $table->decimal('district_allocation', 12, 2);
            $table->string('vote_number');
            $table->date('date');
            $table->decimal('amount', 12, 2);
            $table->text('purpose');
            $table->string('division_name');
            $table->string('gn_division');
            $table->string('village');
            $table->string('contacted_staff');
            $table->date('awareness_date')->nullable();
            $table->date('stakeholder_awareness_date')->nullable();
            $table->integer('participants_count')->default(0);
            $table->date('launching_date')->nullable();
            $table->integer('ceremony_participants_count')->default(0);
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
        Schema::dropIfExists('community_model_village');
    }
};
