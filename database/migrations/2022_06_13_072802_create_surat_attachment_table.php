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
        Schema::create('surat_attachment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_surat');
            $table->string('id_user_warga');
            $table->longText('fileKTP');
            $table->longText('fileKK');
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
        Schema::dropIfExists('surat_attachment');
    }
};
