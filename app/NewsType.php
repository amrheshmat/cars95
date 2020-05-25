<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    //Main Table 
        //Table Name
        protected $fillable = ['type_ar','type_en'];
    //For index 
    public $dataTable= [
        'id'                => array('search_type'=>'equal'        , 'query_value'=>'id'        , 'query_as'=>'id'),
        'type_ar'           => array('search_type'=>'like'         , 'query_value'=>'type_ar'   , 'query_as'=>'type_ar'),
        'type_en'           => array('search_type'=>'like'         , 'query_value'=>'type_en'   , 'query_as'=>'type_en'),
    ];
    //Create Customer 
        public $createAdmin= [
            'type_ar'   => array('type'=>'text','value' =>'','required'=>'required'),
            'type_en'   => array('type'=>'text','value' =>'','required'=>'required'),
        ];
        public $editAdmin= [
            'type_ar'   => array('type'=>'text','value' =>'','required'=>'required'),
            'type_en'   => array('type'=>'text','value' =>'','required'=>'required'),
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


