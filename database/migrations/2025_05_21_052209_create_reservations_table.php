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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('time_slot_id')->nullable();
            $table->foreign('time_slot_id')
                ->references('id')
                ->on('time_slots')
                ->onDelete('set null')
                ->cascadeOnUpdate();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->cascadeOnUpdate();
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->string('payment_status')->default('unpaid'); // unpaid, paid
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
