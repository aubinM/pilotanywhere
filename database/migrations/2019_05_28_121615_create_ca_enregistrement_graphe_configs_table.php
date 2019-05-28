<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaEnregistrementGrapheConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ca_enregistrement_graphe_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('materiel_autonome_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->smallInteger('type');
            $table->char('hex',40);
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
        Schema::dropIfExists('ca_enregistrement_graphe_configs');
    }
}
