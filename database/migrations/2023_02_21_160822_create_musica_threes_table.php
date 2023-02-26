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
        Schema::create('musica_threes', function (Blueprint $table) {
            $table->id();
            $table->string('tema',250);
            $table->string('genero',250);
            $table->string('descripcion',250);
            $table->integer('duracion');
            $table->string('imagen',500);
            $table->string('audio',500);
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
        Schema::dropIfExists('musica_threes');
    }
};
