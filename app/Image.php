<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{    
    //Columns Name
        protected $fillable = ['image','model_id','model_type','created_by','updated_by'];
}
