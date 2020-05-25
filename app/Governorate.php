<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{    
    //Columns Name
        protected $fillable = ['country_id','governorate_desc_ar','governorate_desc_en','governorate_logo','created_by','updated_by'];
    //For index 
        public $dataTable= [
            'id_governorate'        => array('search_type'=>'equal' , 'query_value'=>'governorates.id'      , 'query_as'=>'id_governorate'),
            'country_desc_ar'       => array('search_type'=>'getAllList'  , 'query_value'=>'country_desc_ar'      , 'query_as'=>'country_desc_ar','name'=>'countries--country_desc_ar','extra_value'=> array('model'=>'Country','index'=>'country_desc_ar','value'=>'country_desc_ar')),        
            'governorate_desc_ar'   => array('search_type'=>'like'  , 'query_value'=>'governorate_desc_ar'  , 'query_as'=>'governorate_desc_ar'),
            'governorate_desc_en'   => array('search_type'=>'like'  , 'query_value'=>'governorate_desc_en'  , 'query_as'=>'governorate_desc_en'),
        ];
    //For Create
        public $modelcreate= [
            'country_id'            => array('type'=>'list'     ,'value' =>'','required'=>'required'),
            'governorate_desc_ar'   => array('type'=>'text'     ,'value' =>'','required'=>'required'),
            'governorate_desc_en'   => array('type'=>'text'     ,'value' =>'','required'=>'required'),
            // 'governorate_logo'   => array('type'=>'file'    ,'value' => '','required'=>'notrequired'),
        	];
    //For Edit
        public $modelEditor= [
            // 'governorate_logo'   => array('type'=>'file'    ,'value' => '','required'=>'notrequired','colmd'=>'col-md-12'),
            'country_id'            => array('type'=>'list'     ,'value' =>'','required'=>'required'),
            'governorate_desc_ar'   => array('type'=>'text'     ,'value' =>'','required'=>'required'),
            'governorate_desc_en'   => array('type'=>'text'     ,'value' =>'','required'=>'required'),
        	];
        //relationShip
        public function Country(){return $this->belongsTo('App\Country','country_id','id');}
    // Helper Query 
        function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw("
                    governorates.*,
                    governorates.id as id_governorate,
                    governorates.id as `id`,
                    countries.country_desc_ar as 'country_desc_ar'
                ")
            ->join('countries'  ,'country_id','=','countries.id')


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
                                $query->whereNotNull('governorates.id');
                        }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('governorates.id')
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
