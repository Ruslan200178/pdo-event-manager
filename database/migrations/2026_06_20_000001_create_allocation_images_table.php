<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('allocation_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('allocation_id')->constrained('allocations')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('allocation_images');
    }
};
?>
