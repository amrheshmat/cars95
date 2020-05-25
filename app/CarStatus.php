<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarStatus extends Model
{
    protected $fillable = ['id','name'];
    public $dataTable= [
        'id'                => array('search_type'=>'equal'        , 'query_value'=>'id'        , 'query_as'=>'id'),
        'name'           => array('search_type'=>'like'         , 'query_value'=>'name'   , 'query_as'=>'name'),
    ];
    //Create Customer 
        public $createAdmin= [
            'name'   => array('type'=>'text','value' =>'','required'=>'required'),
        ];
        public $editAdmin= [
            'name'   => array('type'=>'text','value' =>'','required'=>'required')
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
