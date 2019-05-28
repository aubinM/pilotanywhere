<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stloup_pasteurisateur_standardisation_data extends Model
{
    public function ca_enregistrements() {
        return $this->hasMany('App\Ca_enregistrement');
    }
}
