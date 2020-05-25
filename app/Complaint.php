<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    //Main Table 
    //Table Name
    public $timestamps = false;
        protected $fillable = ['complaint_type','updated_at'];

        //Main Table 
    
    //For index 
        public $dataTable= [
            'id'                => array('search_type'=>'equal', 'query_value'=>'id', 'query_as'=>'id'),
            'complaint_type' => array('search_type'=>'like'  , 'query_value'=>'complaints.complaint_type', 'query_as'=>'complaint_type','extra_value'=> array('model'=>'Complaint')),
        ];
    //Create Country 
        public $createAdmin= [
            'complaint_type'   => array('type'=>'text','value' =>'','required'=>'required'),
        ];
    //Edit Country 
        public $editAdmin= [
            'complaint_type'   => array('type'=>'text','value' =>'','required'=>'required'),
        ];
    //Relationship
    public function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
        return $query->selectRaw("
        complaints.*,                    
        complaints.id as `id`,
        complaints.complaint_type as `requestcomplaint_typeer_name`
        
            ")->Where(function ($query) use ($columns) 
            {
                if(!empty($columns) and $columns != null) {
                    foreach ($columns as $keys => $values) {
                        if ($values['type'] == 'like') {
                            $query->whereRaw($keys.' like "%'.$values['value'].'%"');
                        }elseif ($values['type'] == 'datatime') {
                            $datatime = explode(' - ', $values['value']);
                            $query->whereBetween($keys, [$datatime[0], $datatime[1]]);
                        }elseif ($values['type'] == 'ENUM' || $values['type'] == 'getAllList') {
                            $query->whereIn($keys, $values['value']);
                        }else{
                            $query->whereRaw($keys.'= "'.$values['value'].'"');
                        }
                    }
                }else{
                        $query->whereNotNull('complaints.id');
                }
        })
        ->orderBy($orderby,$ordertype)
        ->groupBy('complaints.id')
        ->paginate($rows);
    }
   
}
