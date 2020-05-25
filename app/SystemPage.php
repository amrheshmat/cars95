<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemPage extends Model
{
    //Main Table 
    //Table Name
        protected $fillable = ['systemPage_pageDescriptionAR','systemPage_pageDescriptionEN','systemPage_pageURL','created_by','updated_by'];
    //For index 
        public $dataTable= [
            'id'                => array('search_type'=>'equal'        , 'query_value'=>'id'        , 'query_as'=>'id'),
            'systemPage_pageDescriptionAR'   => array('search_type'=>'like'         , 'query_value'=>'systemPage_pageDescriptionAR'   , 'query_as'=>'systemPage_pageDescriptionAR'),
            'systemPage_pageDescriptionEN'   => array('search_type'=>'like'         , 'query_value'=>'systemPage_pageDescriptionEN'   , 'query_as'=>'systemPage_pageDescriptionEN'),
            'systemPage_pageURL'   => array('search_type'=>'like'         , 'query_value'=>'systemPage_pageURL'   , 'query_as'=>'systemPage_pageURL'),
        ];
    //Create Country 
        public $createAdmin= [
            'systemPage_pageDescriptionAR'   => array('type'=>'text','value' =>'','required'=>'required'),
            'systemPage_pageDescriptionEN'   => array('type'=>'text','value' =>'','required'=>'required'),
            'systemPage_pageURL'   => array('type'=>'text','value' =>'','required'=>'required'),
        ];
    //Edit Country 
        public $editAdmin= [
            'systemPage_pageDescriptionAR'   => array('type'=>'text','value' =>'','required'=>'required'),
            'systemPage_pageDescriptionEN'   => array('type'=>'text','value' =>'','required'=>'required'),
            'systemPage_pageURL'   => array('type'=>'text','value' =>'','required'=>'required'),
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


