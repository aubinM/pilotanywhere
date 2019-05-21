<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaEnregistrementMaterielOrigineTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ca_enregistrement_materiel_origine', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('ca_enregistrement_id');
            $table->unsignedBigInteger('materiel_origine_id');

            $table->foreign('ca_enregistrement_id')->references('id')->on('ca_enregistrements')->onDelete('cascade');
            $table->foreign('materiel_origine_id')->references('id')->on('materiel_origines')->onDelete('cascade');
            
            $table->float('volume_debut');
            $table->float('volume_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ca_enregistrement_materiel_origine');
    }

}
