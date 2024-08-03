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
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('lebar_depan_bangunan')->nullable();
            $table->integer('jumlah_lantai')->nullable();
            $table->integer('garasi')->nullable();
            $table->integer('carport')->nullable();
            $table->renameColumn('posisi_rumah', 'hadap');
            $table->dropColumn('garasi_dan_carport');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('lebar_depan_bangunan');
            $table->dropColumn('jumlah_lantai');
            $table->dropColumn('garasi');
            $table->dropColumn('carport');
            $table->renameColumn('hadap', 'posisi_rumah');
            $table->integer('garasi_dan_carport')->nullable();
        });
    }
};
