<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('packing')) {
            Schema::create('packing', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_produksi');
                $table->integer('jumlah_packing')->default(0);
                $table->unsignedBigInteger('p_jawab')->nullable();
                $table->string('status')->default('proses');
                $table->timestamps();
                $table->foreign('id_produksi')->references('id')->on('produksi')->onDelete('cascade');
                $table->foreign('p_jawab')->references('id')->on('karyawan')->onDelete('set null');
            });
        }
   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packing');
    }
}
