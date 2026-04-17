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
        Schema::table('security_officers', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->json('nic_photo_path')->nullable()->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('security_officers', function (Blueprint $table) {
            //
        });
    }
};
