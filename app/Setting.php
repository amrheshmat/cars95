<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //Main Table 
    //Table Name
        protected $fillable = ['key','display_name','value','details','type','order','group','created_by','updated_by'];
    //For index 
        public $dataTable= [
            'id'            => array('search_type'=>'equal'        , 'query_value'=>'id'        , 'query_as'=>'id'),            
            'display_name'  => array('search_type'=>'like'         , 'query_value'=>'display_name'   , 'query_as'=>'display_name'),
            'value'         => array('search_type'=>'like'         , 'query_value'=>'value'   , 'query_as'=>'value'),
            'details'       => array('search_type'=>'like'         , 'query_value'=>'details'   , 'query_as'=>'details'),
            'type'          => array('search_type'=>'like'         , 'query_value'=>'type'   , 'query_as'=>'type'),            
            'min_supported_version'         => array('search_type'=>'like'         , 'query_value'=>'min_supported_version'   , 'query_as'=>'min_supported_version'),
            
        ];
    //Create Country 
        public $createAdmin= [
            'key'           => array('type'=>'text','value' =>'','required'=>'required'),
            'display_name'  => array('type'=>'text','value' =>'','required'=>'required'),
            'value'         => array('type'=>'text','value' =>'','required'=>'required'),
            'details'       => array('type'=>'text','value' =>'','required'=>'required'),
            'type'          => array('type'=>'text','value' =>'','required'=>'required'),
            'order'         => array('type'=>'text','value' =>'','required'=>'required'),
            'group'   => array('type'=>'text','value' =>'','required'=>'required'),
            'min_supported_version'   => array('type'=>'text','value' =>'','required'=>'required'),
            
        ];
    //Edit Country 
        public $editAdmin= [
            'key'   => array('type'=>'text','value' =>'','required'=>'required'),
            'display_name'   => array('type'=>'text','value' =>'','required'=>'required'),
            'value'   => array('type'=>'text','value' =>'','required'=>'required'),
            'details'   => array('type'=>'text','value' =>'','required'=>'required'),
            'type'   => array('type'=>'text','value' =>'','required'=>'required'),
            'order'   => array('type'=>'text','value' =>'','required'=>'required'),
            'group'   => array('type'=>'text','value' =>'','required'=>'required'),
            'min_supported_version'   => array('type'=>'text','value' =>'','required'=>'required'),
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


