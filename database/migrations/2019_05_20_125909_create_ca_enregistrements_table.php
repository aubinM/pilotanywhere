<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaEnregistrementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ca_enregistrements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('materiel_autonome_id');
            $table->integer('run');


            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin')->nullable();
            $table->float('total_volumes');
            $table->float('test_recyclage')->nullable();
            $table->boolean('test_recyclage_valide')->nullable();
            $table->float('test_delta_temperature')->nullable();
            $table->boolean('test_delta_temperature_valide')->nullable();
            $table->float('test_delta_pression')->nullable();
            $table->boolean('test_delta_pression_valide')->nullable();
            $table->boolean('validation_globale')->nullable();
            $table->dateTime('checked_at')->nullable();
            $table->integer('checked_by')->nullable();
            $table->string('commentaire', 280);



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ca_enregistrements');
    }

}
