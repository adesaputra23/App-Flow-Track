<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProduksiBahanBakuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_produksi_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produksi');
            $table->unsignedBigInteger('id_bahan_baku');
            $table->foreign('id_produksi')->references('id')->on('produksi')->onDelete('cascade');
            $table->foreign('id_bahan_baku')->references('id')->on('bahan_baku')->onDelete('cascade');
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
        Schema::dropIfExists('detail_produksi_bahan_baku');
    }
}
