<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('errorlog', function (Blueprint $table) {
            $table->id();
            $table->text('error_message')->nullable();
            $table->text('line_number')->nullable();
            $table->text('file_name')->nullable();
            $table->text('browser')->nullable();
            $table->text('operating_system')->nullable();
            $table->text('loggedin_id')->nullable();
            $table->text('ip_address')->nullable();
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
        Schema::dropIfExists('errorlog');
    }
}
