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
        Schema::create('certification_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('institution');
            $table->integer('students_count')->default(0);
            $table->integer('modules_count')->default(0);
            $table->date('starting_date');
            $table->date('closing_date');
            $table->date('exam_date')->nullable();
            $table->integer('eligible_students_count')->default(0);
            $table->date('ceremony_date')->nullable();
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
        Schema::dropIfExists('certification_courses');
    }
};
