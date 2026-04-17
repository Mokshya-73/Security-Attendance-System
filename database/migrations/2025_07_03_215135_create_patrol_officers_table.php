<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('patrol_officers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slt_employee_id')->unique();
            $table->foreignId('assigned_manager_id')->constrained('security_managers');
            $table->foreignId('user_core_data_id')->constrained('user_core_data');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrol_officers');
    }
};
