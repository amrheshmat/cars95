<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Log extends Model
{
    //Main Table 
        //Table Name 
        protected $fillable = ['user_id','route','model','methods','created_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
    protected $dates  = ['created_at'];
  /*
     * The attributes that for dataTable.
     *
     * @var array
     */
    public $dataTable= [
        'username'          => array('search_type'=>'like'         , 'query_value'=>'username'    , 'query_as'=>'username'),
        'events'             => array('search_type'=>'like'         , 'query_value'=>'route'       , 'query_as'=>'route'),
          'action_Date'         => array('search_type'=>'datatime'       , 'query_value'=>'logs.created_at'    , 'query_as'=>'created_at'),
    ];

    public $createAdmin= [
           'username'          => array('search_type'=>'like'         , 'query_value'=>'username'    , 'query_as'=>'username'),
        'events'             => array('search_type'=>'like'         , 'query_value'=>'route'       , 'query_as'=>'route'),
          'action_Date'         => array('search_type'=>'datatime'       , 'query_value'=>'logs.created_at'    , 'query_as'=>'created_at')
    ];
    
    public $editAdmin= [
       'username'          => array('search_type'=>'like'         , 'query_value'=>'users.username'    , 'query_as'=>'username'),
        'action'             => array('search_type'=>'like'         , 'query_value'=>'route'       , 'query_as'=>'route'),
          'action_Date'         => array('search_type'=>'datatime'       , 'query_value'=>'logs.created_at'    , 'query_as'=>'created_at'),
    ];

    //New function
        //public function club(){return $this->belongsTo('App\club','club_id','id');}
    // Helper Query           
        public function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw('
            logs.*,
            username
            ')
            ->join('users'     , 'logs.user_id','=', 'users.id')    
            ->Where(function ($query) use ($columns) {
                if(!empty($columns) and $columns != null) {
                    foreach ($columns as $keys=>$values) {
                        if ($values['type'] == 'like' ) {
                            $query->whereRaw($keys.' like "%'.$values['value'].'%"');
                        }elseif ($values['type'] == 'datatime') {
                            $datatime = explode(' - ', $values['value']);
                            $query->whereBetween($keys, [$datatime[0], $datatime[1]]);
                        }elseif ($values['type'] == 'ENUM' || $values['type'] == 'getAllList') {
                            $query->whereIn($keys, $values['value']);
                        }elseif ($values['type'] == 'FIND_IN_SET') {
                            $query->whereRaw($keys.'= "'.implode("",$values['value']).'"');
                        }elseif ($values['type'] == 'Having') {
                            // $query->whereRaw($keys.'>= "'.$values['value'].'"');
                        }else{
                            $query->whereRaw($keys.'= "'.$values['value'].'"');
                        }
                    }
                }else{
                    $query->whereNotNull('logs.id');
                }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('logs.id')
            ->paginate($rows);
        }

}


