<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->unsignedBigInteger('id_bahan_baku')->nullable();
            $table->unsignedBigInteger('id_detail_pesanan')->nullable();
            $table->integer('jumlah_bahan')->nullable();
            $table->integer('jumlah_batang_gagal_produksi')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam_produksi')->nullable();
            $table->string('status_produksi')->nullable();
            $table->foreign('id_bahan_baku')->references('id')->on('bahan_baku')->onDelete('no action');
            $table->foreign('id_detail_pesanan')->references('id')->on('table_detail_pesanan')->onDelete('no action');
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
        Schema::dropIfExists('produksi');
    }
}
