<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materiel_destination extends Model
{
    public function materiel_autonome() {
        return $this->belongsTo('App\Materiel_autonome');
    }
    public function ca_enregistrements() {
        return $this->belongsToMany('App\Ca_enregistrement')->withPivot('volume_debut', 'volume_fin');
    }

    public function materiel_origines() {
        return $this->belongsToMany('App\Materiel_origine')->withPivot('volume');
    }
}
