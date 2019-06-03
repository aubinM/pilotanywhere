<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ca_enregistrement_graphe_config extends Model
{
    public function materiel_autonome() {
        return $this->belongsTo('App\Materiel_autonome');
    }
}
