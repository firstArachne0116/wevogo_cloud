<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonebookContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pb_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->string('mobile_number');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code');
            $table->string('country')->nullable();
            $table->string('extension')->index();
            $table->string('email');
            $table->integer('department_id');
            $table->string('company_id')->nullable();
            $table->string('accessibility')->nullable();
            $table->smallInteger('stage')->nullable();
            $table->integer('wevo_server_id')->index();
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
