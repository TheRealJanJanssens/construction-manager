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
        Schema::create('read_logs', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('user_uuid');
            $table->uuid('readable_uuid');
            $table->string('readable_type');
            $table->dateTime('read_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('read_logs');
    }
};
