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
        Schema::create('property', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('tipe');
            $table->string('tipe_bangunan');
            $table->integer('harga');
            $table->text('deskripsi');
            $table->string('area');
            $table->integer('kamar_tidur');
            $table->integer('kamar_mandi');
            $table->integer('luas_tanah');
            $table->integer('luas_bangunan');
            $table->integer('kamar_tidur_pembantu');
            $table->integer('kamar_mandi_pembantu');
            $table->string('listrik');
            $table->string('air');
            $table->string('sertifikat');
            $table->string('posisi_rumah');
            $table->boolean('garasi_dan_carport');
            $table->string('kondisi_bangunan');
            $table->foreignId('agent_id')->constrained('users'); // Replace 'users' with the actual table name for the users.
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
        Schema::dropIfExists('property');
    }
};
