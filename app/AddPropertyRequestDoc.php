<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddPropertyRequestDoc extends Model
{
    protected $primaryKey = 'id'; // or null
    //Columns Name
        protected $fillable = ['medical_request_id','doc'];
    //For index 
    protected $table = "add_property_request_docs";
}
