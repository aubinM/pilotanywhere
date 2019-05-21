<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    public function materiel_origine() {
        return $this->hasMany('App\Materiel_origine');
    }
    public function materiel_autonome() {
        return $this->belongsTo('App\Materiel_autonome');
    }
}
