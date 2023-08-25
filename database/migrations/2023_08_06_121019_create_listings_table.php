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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('tipe');
            $table->string('tipe_bangunan');
            $table->string('harga');
            $table->string('deskripsi');
            $table->string('area');
            $table->integer('luas_tanah');
            $table->integer('luas_bangunan');
            $table->integer('kamar_tidur');
            $table->integer('kamar_mandi');
            $table->integer('kamar_tidur_pembantu');
            $table->integer('kamar_mandi_pembantu');
            $table->string('listrik');
            $table->string('air');
            $table->string('sertifikat');
            $table->string('hadap');
            $table->boolean('garasi_dan_carport');
            $table->string('furnished');
            $table->foreignId('user_id')->constrained('users'); // Replace 'users' with the actual table name for the users.
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
        Schema::dropIfExists('listings');
    }
};
