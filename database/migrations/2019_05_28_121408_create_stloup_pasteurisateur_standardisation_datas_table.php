<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStloupPasteurisateurStandardisationDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stloup_pasteurisateur_standardisation_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ca_enregistrement_id');
            $table->dateTime('_date')->unique();
            
            $table->float('Debit_Envoi');
            $table->float('Debit_Retour');
            $table->float('Conductivite_Retour');
            $table->float('Temp_Retour');
            $table->float('Temp_Cuve_Soude');
            $table->float('Conductivite_Cuve_Soude');
            $table->float('Niveau_Cuve_Soude');
            $table->float('Temp_Cuve_Acide');
            $table->float('Conductivite_Cuve_Acide');
            $table->float('Niveau_Cuve_Acide');
            $table->float('Pression_Envoi');
            $table->float('Turbidite_Retour');
            
            $table->boolean('envoi_eau_neuve');
            $table->boolean('envoi_eau_recuperee');
            $table->boolean('envoi_acide');
            $table->boolean('envoi_soude');
            $table->boolean('pompe_envoi');
            $table->boolean('retour_eau_recuperee');
            $table->boolean('retour_acide');
            $table->boolean('retour_soude');
            $table->boolean('retour_egout');
            $table->boolean('Niveau_Haut_Cuve_Soude');
            $table->boolean('Niveau_Haut_Cuve_Acide');
            $table->boolean('Niveau_Haut_Cuve_Eau_Recuperee');
            $table->boolean('pompe_doseuse_desinfectant');
            $table->boolean('niveau_haut_eau_propre');
            $table->boolean('niveau_bas_eau_propre');
            $table->boolean('niveau_bas_eau_recuperee');
            $table->boolean('niveau_bas_soude');
            $table->boolean('niveau_bas_acide');
            $table->boolean('vanne_alim_eau_neuve_cuve_eau_propre');
            $table->boolean('vanne_alim_eau_neuve_cuve_soude');
            $table->boolean('vanne_alim_eau_neuve_cuve_acide');
            $table->boolean('vanne_alim_eau_polishee_cuve_soude');
            $table->boolean('vanne_alim_eau_polishee_cuve_acide');
            $table->boolean('securisation');
               
            $table->timestamps();
            $table->index('ca_enregistrement_id','ca_enregistrement_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stloup_pasteurisateur_standardisation_datas');
    }
}
