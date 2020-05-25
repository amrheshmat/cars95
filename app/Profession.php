<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    public function provider()
    {
        return $this->hasMany('App\MedicalProvider');
    }
}
