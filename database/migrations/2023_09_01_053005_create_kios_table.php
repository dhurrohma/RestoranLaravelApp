<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kios', function (Blueprint $table) {
            $table->id();
            $table->string('kios', 100);
            $table->string('alamat', 100);
            $table->string('nama_pemilik', 100);
            $table->string('no_telp', 100);
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
        Schema::dropIfExists('kios');
    }
}
