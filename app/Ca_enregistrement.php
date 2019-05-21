<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ca_enregistrement extends Model {

    public function materiel_autonome() {
        return $this->belongsTo('App\Materiel_autonome');
    }

    public function alarmes() {
        return $this->belongsToMany('App\Alarme');
    }

    public function materiel_origines() {
        return $this->belongsToMany('App\Materiel_origine')->withPivot('volume_debut', 'volume_fin');
    }
    public function materiel_destinations_materiel_origines() {
        return $this->belongsToMany('App\Materiel_origine','ca_enregistrement_materiel_destination_materiel_origine')->withPivot('volume');
    }

}
