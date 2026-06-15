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
        Schema::create('five_s_certification', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->string('institution');
            $table->date('date');
            $table->string('division');
            $table->integer('participants_count')->default(0);
            $table->string('status')->default('Pending'); // e.g. Pending, Certified, Rejected
            $table->string('document_path')->nullable();
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
        Schema::dropIfExists('five_s_certification');
    }
};
