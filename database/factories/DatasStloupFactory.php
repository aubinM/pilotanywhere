<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Stloup_pasteurisateur_standardisation_data;
use Faker\Generator as Faker;



$factory->define(Stloup_pasteurisateur_standardisation_data::class, function (Faker $faker, $options) {
    
    
    
    return [
        'ca_enregistrement_id' => 1,
        'Debit_Envoi' => $faker->randomFloat(2, 30, 32),
        'Debit_Retour' => $faker->randomFloat(2, 40, 42),
        'Temp_Retour' => $faker->randomFloat(2, 25, 35),
        'Conductivite_Retour' => $faker->randomFloat(2, 0, 1),
        'Temp_Cuve_Soude' => $faker->randomFloat(2, 75, 80),
        'Conductivite_Cuve_Soude' => $faker->randomFloat(2, 35, 40),
        'Niveau_Cuve_Soude' => $faker->randomFloat(2, 4000, 6000),
        'Temp_Cuve_Acide' => $faker->randomFloat(2, 65, 75),
        'Conductivite_Cuve_Acide' => $faker->randomFloat(2, 35, 45),
        'Niveau_Cuve_Acide' => $faker->randomFloat(2, 4000, 6000),
        'Pression_Envoi' => $faker->randomFloat(2, 45, 55),
        'Turbidite_Retour' => $faker->randomFloat(2, 0, 1),
        'envoi_eau_neuve' => $faker->numberBetween(1, 1),
        'envoi_eau_recuperee' => $faker->numberBetween(1, 1),
        'envoi_acide' => $faker->numberBetween(1, 1),
        'envoi_soude' => $faker->numberBetween(1, 1),
        'pompe_envoi' => $faker->numberBetween(1, 1),
        'retour_eau_recuperee' => $faker->numberBetween(1, 1),
        'retour_acide' => $faker->numberBetween(1, 1),
        'retour_soude' => $faker->numberBetween(1, 1),
        'retour_egout' => $faker->numberBetween(1, 1),
        'Niveau_Haut_Cuve_Soude' => $faker->numberBetween(1, 1),
        'Niveau_Haut_Cuve_Acide' => $faker->numberBetween(1, 1),
        'Niveau_Haut_Cuve_Eau_Recuperee' => $faker->numberBetween(1, 1),
        'pompe_doseuse_desinfectant' => $faker->numberBetween(1, 1),
        'niveau_haut_eau_propre' => $faker->numberBetween(1, 1),
        'niveau_bas_eau_recuperee' => $faker->numberBetween(1, 1),
        'niveau_bas_eau_propre' => $faker->numberBetween(1, 1),
        'niveau_bas_soude' => $faker->numberBetween(1, 1),
        'niveau_bas_acide' => $faker->numberBetween(1, 1),
        'vanne_alim_eau_neuve_cuve_eau_propre' => $faker->numberBetween(1, 1),
        'vanne_alim_eau_neuve_cuve_soude' => $faker->numberBetween(1, 1),
        'vanne_alim_eau_neuve_cuve_acide' => $faker->numberBetween(1, 1),
        'vanne_alim_eau_polishee_cuve_soude' => $faker->numberBetween(1, 1),
        'vanne_alim_eau_polishee_cuve_acide' => $faker->numberBetween(1, 1),
        'securisation' => $faker->numberBetween(1, 1)
    ];
});
