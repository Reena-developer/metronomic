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
        Schema::create('exceptions_log', function (Blueprint $table) {
            $table->id();
            $table->longText('error_message');
            $table->longText('stack_trace');
            $table->string('method');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exceptions_log');
    }
};
