<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    //Main Table 
    //Table Name
        protected $fillable = ['session_desc_ar','session_desc_en','season_startDate','season_endDate','created_by','updated_by'];
    //For index 
        public $dataTable= [
            'id'                => array('search_type'=>'equal'        , 'query_value'=>'id'                , 'query_as'=>'id'),
            'session_desc_ar'   => array('search_type'=>'like'         , 'query_value'=>'session_desc_ar'   , 'query_as'=>'session_desc_ar'),
            'session_desc_en'   => array('search_type'=>'like'         , 'query_value'=>'session_desc_en'   , 'query_as'=>'session_desc_en'),
            'season_startDate'  => array('search_type'=>'datatime'       , 'query_value'=>'season_startDate'    , 'query_as'=>'season_startDate'),
            'season_endDate'    => array('search_type'=>'datatime'       , 'query_value'=>'season_endDate'      , 'query_as'=>'season_endDate'),

        ];
    //Create Country 
        public $createAdmin= [
            'session_desc_ar'   => array('type'=>'text','value' =>'','required'=>'required'),
            'session_desc_en'   => array('type'=>'text','value' =>'','required'=>'required'),
            'season_startDate'  => array('type'=>'datetime' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),
            'season_endDate'    => array('type'=>'datetime' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),
        ];
    //Edit Country 
        public $editAdmin= [
            'session_desc_ar'   => array('type'=>'text','value' =>'','required'=>'required'),
            'session_desc_en'   => array('type'=>'text','value' =>'','required'=>'required'),
            'season_startDate'  => array('type'=>'datetime' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),
            'season_endDate'    => array('type'=>'datetime' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),
        ];
    //Relationship
    public function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
        return $query->selectRaw('*')
        ->Where(function ($query) use ($columns) 
                {
                    if(!empty($columns) and $columns != null) {
                        foreach ($columns as $keys => $values) {
                            if ($values['type'] == 'like') {
                                $query->whereRaw($keys.' like "%'.$values['value'].'%"');
                            }elseif ($values['type'] == 'datatime') {
                                $datatime = explode(' - ', $values['value']);
                                $query->whereBetween($keys, [$datatime[0], $datatime[1]]);
                            }else{
                                $query->whereRaw($keys.'= "'.$values['value'].'"');
                            }
                        }
                    }else{
                            $query->whereNotNull('id');
                    }
        })
        ->orderBy($orderby,$ordertype)
        ->groupBy('id')
        ->paginate($rows);
    }
}


