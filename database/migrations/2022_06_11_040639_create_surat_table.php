<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('id_user_warga');
            $table->string('id_status_surat');
            $table->string('no_surat');
            $table->string('keperluan');
            $table->longText('keterangan');
            $table->longText('catatan')->nullable();
            $table->longText('lainnya')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat');
    }
};
