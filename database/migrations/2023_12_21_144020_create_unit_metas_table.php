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
        Schema::create('unit_metas', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('unit_uuid');
            $table->string('type')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('completed_date')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_metas');
    }
};
