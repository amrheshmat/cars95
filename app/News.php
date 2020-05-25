<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{    
    //Columns Name
        protected $fillable = ['id','title','desc','img','news_type_id','main_club_id','sub_club_id','source','created_by','updated_by'];
    //For index 
        public $dataTable= [
            'img'               => array('search_type'=>'img'   , 'query_value'=>'img'       , 'query_as'=>'img'),
            'news_type_name' =>array('search_type'=>'getAllList'  ,'query_value'=>'news_types.type_ar'     ,'query_as'=>'news_type_name','name'=>'news_types--type_ar','extra_value'=> array('model'=>'NewsType','index'=>'type_ar','value'=>'type_ar')),            
            'title'             => array('search_type'=>'like'  , 'query_value'=>'title'    , 'query_as'=>'title'),    
        ];
    //For Create
        public $modelcreate= [
           
            'img'           => array('type'=>'file'    ,'value' => '','required'=>'required','colmd'=>'col-md-12'),
            'news_type_id'  => array('type'=>'list'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'title'         => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'desc'          => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-6'),
            'source'        => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),

            
        	];
    //For Edit
        public $modelEditor= [
            'img'           => array('type'=>'file'    ,'value' => '','required'=>'no','colmd'=>'col-md-12'),
            'news_type_id'  => array('type'=>'list'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'title'         => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'desc'          => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-6'),
            'source'        => array('type'=>'text'     ,'value' =>'','required'=>'required','colmd'=>'col-md-6'),
        	];
        //relationShip
        public function NewsType(){return $this->belongsTo('App\NewsType','news_type_id','id');}
    // Helper Query 
        function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw("
                    news.*,                    
                    news.id as `id`,
                    news_types.type_ar as 'news_type_name'
                ")
            ->join('news_types'  ,'news.news_type_id','=','news_types.id')
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
                                $query->whereNotNull('news.id');
                        }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('news.id')
            ->paginate($rows);
        }
        function scopeGetSearch($query,$search = ''){
            return 
                $query->selectRaw('
                    nfc_city.image as image,
                    nfc_city.lat as lat,
                    nfc_city.lng as lng,
                    nfc_city.ar_name as dest_ar,
                    nfc_city.en_name as dest_en,
                    nfc_city.id,
                    nfc_city.description,
                    nfc_city.type,
                    CONCAT(nfc_state.ar_name,", ", nfc_country.ar_name) as ar_name,
                    CONCAT(nfc_state.en_name,", ", nfc_country.en_name) as en_name'
                )
                ->join('nfc_state'  , 'nfc_state.id'  ,'=', 'nfc_city.state_id')
                ->join('nfc_country', 'nfc_country.id','=', 'nfc_state.country_id')
                ->Where(function ($query) use ($search){
                    if(!empty($search) and $search != null) {
                        $query->Where('nfc_city.description', 'like', '%' . str_replace(' ','%',$search) . '%')
                        ->orWhere('nfc_city.description', 'like', '%' . str_replace(' ','%',$search) . '%');
                    }
                });
        }
        function scopeGetData($query){
            $query->selectRaw('nfc_city.image as image,nfc_city.lat as lat,nfc_city.lng as lng,nfc_city.ar_name as dest_ar,nfc_city.en_name as dest_en,nfc_city.id,nfc_city.description,nfc_city.type,CONCAT(nfc_state.ar_name,", ", nfc_country.ar_name) as ar_name,CONCAT(nfc_state.en_name,", ", nfc_country.en_name) as en_name')->join('nfc_state'  , 'nfc_state.id'  ,'=', 'nfc_city.state_id')->join('nfc_country', 'nfc_country.id','=', 'nfc_state.country_id')->where('nfc_city.featured','1')->orderBy('nfc_city.featured_style');
        }
}
