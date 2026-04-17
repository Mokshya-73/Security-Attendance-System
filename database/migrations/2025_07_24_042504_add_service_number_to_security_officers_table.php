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
        Schema::table('security_officers', function (Blueprint $table) {
            $table->string('service_number')->nullable()->after('nic');
        });
    }

    public function down()
    {
        Schema::table('security_officers', function (Blueprint $table) {
            $table->dropColumn('service_number');
        });
    }

};
