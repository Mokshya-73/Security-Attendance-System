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
        Schema::create('security_officer_titles', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., Mr, Mrs, Dr
            $table->timestamps();
        });

        Schema::table('security_officers', function (Blueprint $table) {
            $table->foreignId('title_id')->nullable()->constrained('security_officer_titles')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('security_officers', function (Blueprint $table) {
            $table->dropForeign(['title_id']);
            $table->dropColumn('title_id');
        });

        Schema::dropIfExists('security_officer_titles');
    }

};
