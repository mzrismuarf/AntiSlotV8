<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wordlists', function (Blueprint $table) {
            $table->id();
            $table->string('slot')->nullable();
            $table->string('backdoor')->nullable();
            $table->string('disable_file_modif')->nullable();
            $table->string('disable_xmlrpc')->nullable();
            $table->string('patch_cve')->nullable();
            $table->string('validation_upload')->nullable();
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
        Schema::dropIfExists('wordlists');
    }
}
