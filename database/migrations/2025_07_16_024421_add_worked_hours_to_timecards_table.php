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
        Schema::table('timecards', function (Blueprint $table) {
            $table->decimal('worked_hours', 5, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('timecards', function (Blueprint $table) {
            $table->dropColumn('worked_hours');
        });
    }

};
