<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWevoDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wevo_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wevo_user_id')->unsigned();
            $table->string('acc_uname');
            $table->string('acc_secret');
            $table->string('acc_auth')->nullable();
            $table->string('acc_transport');
            $table->string('acc_proxy')->nullable();
            $table->string('acc_proxy_enable')->default(false);
            $table->string('acc_reg_expire')->nullable();
            $table->string('acc_prefix')->nullable();
            $table->string('acc_avpf_enable')->default(false);
            $table->string('acc_avpf_interval')->nullable();


            $table->string('acc_plus_00')->nullable();
            $table->string('acc_disableac')->nullable();
            $table->string('audio_eco_can_enable')->nullable();
            $table->string('audio_adp_rate_enable')->nullable();
            $table->string('audio_codec_rate_lim')->nullable();
            $table->string('audio_codec')->nullable();
            $table->string('video_enable')->nullable();
            $table->string('video_always_initiate')->nullable();
            $table->string('video_always_accept')->nullable();
            $table->string('video_preset')->nullable();
            $table->string('video_size')->nullable();
            $table->string('video_overlay')->nullable();
            $table->string('video_codec')->nullable();
            $table->string('call_use_internal_ringtone')->nullable();
            $table->string('call_media_encryption')->nullable();
            $table->string('call_dtmf_sipinfo_enable')->nullable();
            $table->string('call_dtmf_rfc2833_enable')->nullable();
            $table->string('call_auto_answer_enable')->nullable();
            $table->string('call_vm_uri')->nullable();
            $table->string('chat_encrypt_enable')->nullable();
            $table->string('chat_share_server')->nullable();
            $table->string('net_wifi_only')->nullable();
            $table->string('net_dmode_enable')->nullable();
            $table->string('net_stun_turn_server')->nullable();
            $table->string('net_ice_enable')->nullable();
            $table->string('net_turn_enable')->nullable();
            $table->string('net_stun_turn_uname')->nullable();
            $table->string('net_stun_turn_pass')->nullable();
            $table->string('net_rnd_ports_enable')->nullable();
            $table->string('net_sip_port')->nullable();
            $table->string('net_push_notify_enable')->nullable();
            $table->string('net_ipv6_allow')->nullable();
            $table->string('adv_flist_subs_enable')->nullable();
            $table->string('adv_bg_enable')->nullable();
            $table->string('adv_svc_notify_enable')->nullable();
            $table->string('adv_boot_start')->nullable();
            $table->string('adv_pa_dname')->nullable();
            $table->string('adv_pa_uname')->nullable();
            $table->timestamps();

            $table->foreign('wevo_user_id')
                ->references('id')
                ->on('wevo_users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
