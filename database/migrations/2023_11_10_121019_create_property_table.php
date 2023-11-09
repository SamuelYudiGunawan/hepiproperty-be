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
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsis')->onDelete('cascade');
            $table->foreignId('kota_id')->nullable()->constrained('kotas')->onDelete('cascade');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('cascade');
            $table->integer('kamar_tidur')->nullable();
            $table->integer('kamar_mandi')->nullable();
            $table->integer('luas_tanah')->nullable();
            $table->integer('luas_bangunan')->nullable();
            $table->integer('kamar_tidur_pembantu')->nullable();
            $table->integer('kamar_mandi_pembantu')->nullable();
            $table->integer('listrik')->nullable();
            $table->string('air')->nullable();
            $table->string('sertifikat')->nullable();
            $table->string('posisi_rumah')->nullable();
            $table->integer('garasi_dan_carport')->nullable();
            $table->string('kondisi_bangunan')->nullable();
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
