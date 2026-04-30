<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('room_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('room_slug', 200)->index();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('user_name', 200);
            $table->unsignedTinyInteger('rating'); // 1..5
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_reviews');
    }
};
