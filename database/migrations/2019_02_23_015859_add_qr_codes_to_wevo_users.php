<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQrCodesToWevoUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('wevo_users', function($table) {
            $table->string('qrcode_token')->nullable();
            $table->boolean('is_qrcode_used')->default(false);
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
        Schema::table('wevo_users', function($table) {
            $table->dropColumn('qrcode_token');
            $table->dropColumn('is_qrcode_used');
        });
    }
}
