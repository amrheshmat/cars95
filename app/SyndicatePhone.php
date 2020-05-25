<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clubPhone extends Model
{    
    //Columns Name
        protected $fillable = ['club_id','phone','type','created_by','updated_by'];
}
