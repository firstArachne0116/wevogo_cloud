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
            $table->string('email');
            $table->string('display_name')->nullable();
            $table->string('phone_number')->unique();
            $table->string('phone_id')->nullable();
            $table->string('uid')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('freepbx_domain')->nullable();
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
