<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalType extends Model
{
     protected $table = 'medical_types';
     protected $fillable ='name';
}
