<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResultScans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_scans', function (Blueprint $table) {
            $table->id();
            $table->string('directory_scan');
            $table->string('directory_safe')->nullable();
            $table->string('directory_infected')->nullable();
            $table->string('backlink_slot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_scans');
    }
}
