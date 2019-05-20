<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnregistrementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('enregistrements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->dateTime('checked_at');
            $table->integer('checked_by');
            $table->string('commentaire', 280);
            $table->boolean('validation_globale')->nullable();
            $table->float('test_reclyclage');
            $table->boolean('test_reclyclage_valide');
            $table->float('test_delta_temperature');
            $table->boolean('test_delta_temperature_valide');
            $table->float('test_delta_pression');
            $table->boolean('test_delta_pression_valide');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('enregistrements');
    }

}
