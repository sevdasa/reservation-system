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
        Schema::create('bookables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('user_bookable_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')
            ->references('id')
            ->on('types')
            ->onDelete('set null')
            ->cascadeOnUpdate();
            
            $table->foreign('user_bookable_id')
                ->references('id')
                ->on('user_bookables')
                ->onDelete('set null')
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookables');
    }
};
