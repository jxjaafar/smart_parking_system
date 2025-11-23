<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->timestamp('start_time')->nullable()->after('parking_slot_id');
            $table->timestamp('end_time')->nullable()->after('start_time');
            $table->decimal('total_cost', 10, 2)->nullable()->after('end_time');
            $table->boolean('is_paid')->default(false)->after('total_cost');
            $table->string('reservationStatus')->default('Active')->after('is_paid');
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time', 'total_cost', 'is_paid', 'reservationStatus']);
        });
    }
};