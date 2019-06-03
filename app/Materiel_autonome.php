<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Materiel_autonome extends Model {

    public function ca_enregistrements() {
        return $this->hasMany('App\Ca_enregistrement');
    }
    public function matiere() {
        return $this->hasMany('App\Matiere');
    }
    public function materiel_origine() {
        return $this->hasMany('App\Materiel_origine');
    }
    public function materiel_destination() {
        return $this->hasMany('App\Materiel_destination');
    }
    public function ca_enregistrement_graphe_config() {
        return $this->hasMany('App\Ca_enregistrement_graphe_config');
    }
    

}
