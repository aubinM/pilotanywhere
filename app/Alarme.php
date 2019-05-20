<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alarme extends Model
{
    public function ca_enregistrements() {
        return $this->belongsToMany('App\Ca_enregistrement');
    }
}
