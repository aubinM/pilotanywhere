<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmeCaEnregistrementTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('alarme_ca_enregistrement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ca_enregistrement_id');
            $table->integer('alarme_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('alarme_ca_enregistrement');
    }

}
