<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{    
    //Columns Name
    protected $fillable = ['id','car_name','car_price','car_model','car_desc','car_img','car_type','status_id'];
    //For index 
        public $dataTable= [
            'car_name'      => array('search_type'=>'like'   , 'query_value'=>'car_name'       , 'query_as'=>'car_name'),         
            'car_price'       => array('search_type'=>'like'  , 'query_value'=>'car_price'    , 'query_as'=>'car_price'),
            'car_model'       => array('search_type'=>'like'  , 'query_value'=>'car_model'    , 'query_as'=>'car_model'),
            'car_type'       => array('search_type'=>'like'  , 'query_value'=>'car_type'    , 'query_as'=>'car_type'), 
            'status' =>array('search_type'=>'getAllList'  ,'query_value'=>'car_statuses.name'     ,'query_as'=>'status','name'=>'car_statuses.name ','extra_value'=> array('model'=>'CarStatus','index'=>'car_statuses.name','value'=>'car_statuses.name')),  
        ];
    //For Create
        public $modelcreate= [
             'car_img'           => array('type'=>'file'    ,'value' => '','required'=>'no','colmd'=>'col-md-12'),
            'car_name'  => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'car_price'         => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'car_model'          => array('type'=>'text','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-6'),
            'car_type'        => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'car_desc'        => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'status_id'   => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
        	];
    //For Edit
        public $modelEditor= [
       //    'car_img'           => array('type'=>'file'    ,'value' => '','required'=>'no','colmd'=>'col-md-12'),
            'car_name'  => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'car_price'         => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'car_model'          => array('type'=>'text','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-6'),
            'car_type'        => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'car_desc'        => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'status_id'   => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
        	];
        //relationShip
        public function carstatus()
        {
            return $this->belongsTo('App\CarStatus','status_id','id');
        }
    // Helper Query 
        function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw("
                cars.*,
                cars.id as 'id', 
                car_statuses.name as 'status'               
                ")
             ->join('car_statuses'  ,'cars.status_id','=','car_statuses.id')
             ->Where(function ($query) use ($columns) 
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
                                $query->whereNotNull('cars.id');
                        }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('cars.id')
            ->paginate($rows);
        }
        
}
