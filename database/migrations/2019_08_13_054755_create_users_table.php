<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->integer('phone_number')->unique();
            $table->tinyInteger('gender');
            $table->integer('desa_kelurahan_id')->unsigned();
            $table->date('dob');
            $table->string('password');
            $table->timestamps();

            $table->foreign('desa_kelurahan_id')->references('id')->on('rf_desa_kelurahans')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
