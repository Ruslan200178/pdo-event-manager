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
        Schema::create('proyouth_project_proposal', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nic_number');
            $table->string('address');
            $table->integer('age');
            $table->string('ds_division');
            $table->string('institute_school');
            $table->string('proposal_link')->nullable();
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
        Schema::dropIfExists('proyouth_project_proposal');
    }
};
