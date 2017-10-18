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
            $table->integer('wevo_server_id')->index();
            $table->string('email');
            $table->string('display_name')->nullable();
            $table->string('phone_number');
            $table->boolean('is_verified')->default(false);
            $table->string('extension')->nullable();
            $table->string('secret')->nullable();
            $table->string('wevopbx_domain')->nullable();
            $table->string('wevopbx_local_domain')->nullable();
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
