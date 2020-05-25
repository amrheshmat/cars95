<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    //Main Table 
        //Table Name
        protected $fillable = ['ip','note'];
    //For index 
    public $dataTable= [
        // 'id'                => array('search_type'=>'equal'         , 'query_value'=>'id'        , 'query_as'=>'id'),
        'ip'                => array('search_type'=>'like'         , 'query_value'=>'ip'        , 'query_as'=>'ip'),
        'note'              => array('search_type'=>'like'         , 'query_value'=>'note'      , 'query_as'=>'note'),
        // 'created_at'        => array('search_type'=>'like'         , 'query_value'=>'created_at', 'query_as'=>'created_at'),
    ];
    //Create Customer 
        public $createAdmin= [
            'ip'   	=> array('type'=>'data-mask','value' =>'','required'=>'required' ,'data-inputmask' => '"alias" : "ip"'),
            'note'  => array('type'=>'text','value' =>'','required'=>'No'),
        ];
        public $editAdmin= [
            'ip'    => array('type'=>'data-mask','value' =>'','required'=>'required' ,'data-inputmask' => '"alias" : "ip"'),
            'note' => array('type'=>'text','value' =>'','required'=>'No'),
        ];
    //Relationship
    public function users(){ return $this->morphedByMany('App\User', 'iprelation'); }
    public function Callcenters(){ return $this->morphedByMany('App\Callcenter', 'iprelation'); }
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


