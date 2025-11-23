<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        /**
         * FIX 1: Drop any incorrectly named tables
         */
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('parking_slots');
        Schema::dropIfExists('users');
        
        /**
         * FIX 2: Create User table (matching your model)
         */
        if (!Schema::hasTable('User')) {
            Schema::create('User', function (Blueprint $table) {
                $table->id('userID');  // Custom primary key
                $table->string('fullName');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('phoneNumber')->nullable();
                $table->string('role')->default('Driver');
                $table->timestamp('dateRegistered')->useCurrent();
            });
        }

        /**
         * FIX 3: Create parking_slots table (matching your model)
         */
        if (!Schema::hasTable('parking_slots')) {
            Schema::create('parking_slots', function (Blueprint $table) {
                $table->id();  // This creates 'id' column
                $table->string('slotNumber');
                $table->string('location')->nullable();
                $table->string('status')->default('Available');
                $table->decimal('pricePerHour', 8, 2)->nullable();
                $table->text('description')->nullable();
            });
        }

        /**
         * FIX 4: Create Vehicle table
         */
        if (!Schema::hasTable('Vehicle')) {
            Schema::create('Vehicle', function (Blueprint $table) {
                $table->id('vehicleID');
                $table->unsignedBigInteger('userID');
                $table->string('licensePlate')->unique();
                $table->string('vehicleType')->nullable();
                $table->string('make')->nullable();
                $table->string('model')->nullable();
                $table->string('color')->nullable();
                
                $table->foreign('userID')
                      ->references('userID')
                      ->on('User')
                      ->onDelete('cascade');
            });
        }

        /**
         * FIX 5: Create Reservation table (matching your model)
         */
        if (!Schema::hasTable('Reservation')) {
            Schema::create('Reservation', function (Blueprint $table) {
                $table->id('reservationID');  // Custom primary key
                
                // Foreign key to User
                $table->unsignedBigInteger('userID');
                $table->foreign('userID')
                      ->references('userID')
                      ->on('User')
                      ->onDelete('cascade');
                
                // Foreign key to Vehicle
                $table->unsignedBigInteger('vehicleID')->nullable();
                $table->foreign('vehicleID')
                      ->references('vehicleID')
                      ->on('Vehicle')
                      ->onDelete('set null');
                
                // Foreign key to parking_slots
                $table->unsignedBigInteger('slotID');
                $table->foreign('slotID')
                      ->references('id')
                      ->on('parking_slots')
                      ->onDelete('cascade');
                
                $table->timestamp('startTime')->nullable();
                $table->timestamp('endTime')->nullable();
                $table->integer('totalHours')->nullable();
                $table->decimal('totalCost', 10, 2)->nullable();
                $table->string('paymentStatus')->default('Unpaid');
                $table->string('reservationStatus')->default('Active');
                $table->timestamp('createdAt')->useCurrent();
            });
        }

        /**
         * FIX 6: Create Payment table
         */
        if (!Schema::hasTable('Payment')) {
            Schema::create('Payment', function (Blueprint $table) {
                $table->id('paymentID');
                
                $table->unsignedBigInteger('reservationID');
                $table->foreign('reservationID')
                      ->references('reservationID')
                      ->on('Reservation')
                      ->onDelete('cascade');
                
                $table->unsignedBigInteger('userID');
                $table->foreign('userID')
                      ->references('userID')
                      ->on('User')
                      ->onDelete('cascade');
                
                $table->decimal('amount', 10, 2);
                $table->string('paymentMethod');
                $table->string('transactionID')->nullable();
                $table->string('status')->default('Pending');
                $table->timestamp('paymentDate')->useCurrent();
            });
        }

        /**
         * FIX 7: Create ServiceRating table
         */
        if (!Schema::hasTable('ServiceRating')) {
            Schema::create('ServiceRating', function (Blueprint $table) {
                $table->id('ratingID');
                
                $table->unsignedBigInteger('userID');
                $table->foreign('userID')
                      ->references('userID')
                      ->on('User')
                      ->onDelete('cascade');
                
                $table->unsignedBigInteger('slotID');
                $table->foreign('slotID')
                      ->references('id')
                      ->on('parking_slots')
                      ->onDelete('cascade');
                
                $table->integer('rating');
                $table->text('comment')->nullable();
                $table->timestamp('ratingDate')->useCurrent();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('ServiceRating');
        Schema::dropIfExists('Payment');
        Schema::dropIfExists('Reservation');
        Schema::dropIfExists('Vehicle');
        Schema::dropIfExists('parking_slots');
        Schema::dropIfExists('User');
    }
};