<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Materiel_autonome extends Model {

    public function ca_enregistrements() {
        return $this->hasMany('App\Ca_enregistrement');
    }

}
