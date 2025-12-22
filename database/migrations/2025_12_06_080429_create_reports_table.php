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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // user pelapor & terlapor
            $table->unsignedBigInteger('reporter_id');
            $table->unsignedBigInteger('reported_user_id');

            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reported_user_id')->references('id')->on('users')->onDelete('cascade');

            // objek laporan (salah satu)
            $table->unsignedBigInteger('photo_id')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();

            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');

            $table->string('reason'); // sara, pornografi, bullying, spam, penipuan, kekerasan dll
            $table->text('description')->nullable(); // penjelasan tambahan dari pelapor

            $table->enum('status', ['pending', 'reviewed'])->default('pending');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
