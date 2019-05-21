<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materiel_origine extends Model
{
    public function matiere() {
        return $this->belongsTo('App\Matiere');
    }
    public function ca_enregistrements() {
        return $this->belongsToMany('App\Ca_enregistrement')->withPivot('volume_debut', 'volume_fin');
    }
    public function materiel_autonome() {
        return $this->belongsTo('App\Materiel_autonome');
    }
    public function materiel_destinations() {
        return $this->belongsToMany('App\Materiel_destination')->withPivot('volume');
    }
}
