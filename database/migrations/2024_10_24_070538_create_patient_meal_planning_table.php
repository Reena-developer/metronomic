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
        Schema::create('patient_meal_planning', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->index(); // Index for frequent searches
            $table->date('planned_date')->index(); // Index for frequent searches
            $table->decimal('total_calories', 8, 2);
            $table->decimal('total_fats', 5, 2);
            $table->decimal('total_carbs', 5, 2);
            $table->decimal('total_proteins', 5, 2);
            $table->boolean('is_active')->default(true)->index(); // Index for filtering
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // unique constraint
            $table->unique(['patient_id', 'planned_date']);

            // We can foreign key constraints, For the now i have a table only to do this task.
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_meal_planning');
    }
};
