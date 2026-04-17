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
        Schema::create('timecards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patrol_officer_id')->constrained('user_core_data')->onDelete('cascade');
            $table->foreignId('security_officer_id')->constrained('security_officers')->onDelete('cascade');
            $table->foreignId('shift_type_id')->constrained('shift_types')->onDelete('cascade');
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->boolean('is_pay')->default(false);
            $table->boolean('is_overtime')->default(false);
            $table->decimal('overtime_hours', 5, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timecards');
    }
};
