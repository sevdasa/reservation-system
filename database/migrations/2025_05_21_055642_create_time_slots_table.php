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
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bookable_id')->nullable();
            $table->foreign('bookable_id')
                ->references('id')
                ->on('bookables')
                ->onDelete('set null')
                ->cascadeOnUpdate();
            $table->time('start_time');
            $table->time('end_time');
            $table->date('date');
            $table->boolean('is_booked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
