<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('image_path'); // lokasi file foto
            $table->string('caption')->nullable();

            $table->string('camera_type'); // DSLR / Mirrorless / Phone
            $table->string('genre'); // Landscape / Portrait / Street / Macro

            // status foto
            $table->enum('status', ['active', 'banned', 'rejected_ai', 'deleted'])->default('active');

            // alasan ban atau penolakan AI
            $table->text('ban_reason')->nullable();
            $table->text('ai_reason')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
