<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalServiceProviderType extends Model
{
    protected $table = 'medical_service_provicer_types';
    protected $fillable = ['id','provider_type_en','provider_type_ar','created_by','updated_by'];
}
