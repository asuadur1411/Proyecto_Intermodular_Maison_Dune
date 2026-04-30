<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('room_slug')->nullable()->after('event_title')->index();
            $table->string('room_title')->nullable()->after('room_slug');
            $table->date('checkout_date')->nullable()->after('room_title');
            $table->decimal('total_price', 10, 2)->nullable()->after('checkout_date');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['room_slug', 'room_title', 'checkout_date', 'total_price']);
        });
    }
};
