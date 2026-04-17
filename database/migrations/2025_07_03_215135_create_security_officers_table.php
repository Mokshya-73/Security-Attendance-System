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
        Schema::create('security_officers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nic')->unique();
            $table->string('telephone');
            $table->string('address');
            $table->string('nic_photo_path');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('assigned_patrol_id')->constrained('patrol_officers');
            $table->foreignId('user_core_data_id')->constrained('user_core_data');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_officers');
    }
};
