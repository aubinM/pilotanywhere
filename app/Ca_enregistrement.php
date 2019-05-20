<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ca_enregistrement extends Model
{
    public function materiel_autonome() {
        return $this->belongsTo('App\Materiel_autonome');
    }
    public function alarmes() {
        return $this->belongsToMany('App\Alarme');
    }
}
