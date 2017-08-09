<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWevoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wevo_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wevo_user_id')->index();
            $table->integer('freepbx_id')->index();
            $table->string('email')->unique();
            $table->string('display_name')->nullable();
            $table->string('phone_number')->index();
            $table->string('phone_id');
            $table->string('uid')->nullable();
            $table->rememberToken();
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
        //
    }
}