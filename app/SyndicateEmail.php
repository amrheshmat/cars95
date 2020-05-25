<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clubEmail extends Model
{    
    //Columns Name
        protected $fillable = ['club_id','email','type','created_by','updated_by'];
}
