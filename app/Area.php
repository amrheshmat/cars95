<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{    
    protected $primaryKey = 'area_id'; // or null
    //Columns Name
        protected $fillable = ['area_code','area_name','country_id','governorate_id','created_by','updated_by'];
    //For index 
        public $dataTable= [
            'area_id'               => array('search_type'=>'equal' , 'query_value'=>'areas.area_id'      , 'query_as'=>'id_area'),
            'country_desc_ar'       => array('search_type'=>'getAllList'  , 'query_value'=>'country_desc_ar'      , 'query_as'=>'country_desc_ar','name'=>'countries--country_desc_ar','extra_value'=> array('model'=>'Country','index'=>'country_desc_ar','value'=>'country_desc_ar')),
            'governorate_desc_ar'   => array('search_type'=>'getAllList'  , 'query_value'=>'governorate_desc_ar'      , 'query_as'=>'governorate_desc_ar','name'=>'governorates--governorate_desc_ar','extra_value'=> array('model'=>'Governorate','index'=>'governorate_desc_ar','value'=>'governorate_desc_ar')),
            'area_name'             => array('search_type'=>'like'  , 'query_value'=>'area_name'  , 'query_as'=>'area_name'),
        ];
    //For Create
        public $modelcreate= [
            'governorate_id'        => array('type'=>'list'     ,'value' =>'','required'=>'required'),
            'area_name'             => array('type'=>'text'     ,'value' =>'','required'=>'required'),
            // 'governorate_logo'   => array('type'=>'file'    ,'value' => '','required'=>'notrequired'),
        	];
    //For Edit
        public $modelEditor= [
           'governorate_id'        => array('type'=>'list'     ,'value' =>'','required'=>'required'),
            'area_name'             => array('type'=>'text'     ,'value' =>'','required'=>'required'),
        ];
        //relationShip
        public function Country(){return $this->belongsTo('App\Country','country_id','id');}
    //Realtionship 
        public function provider()          { return $this->hasMany('App\MedicalProvider'); }
        public function medical_request()   { return $this->hasMany('App\MedicalRequest'); }
    // Helper Query 
        function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw("
                    areas.*,
                    areas.area_id as id_area,
                    areas.area_id as `id`,
                    countries.country_desc_ar as 'country_desc_ar',
                    governorates.governorate_desc_ar as 'governorate_desc_ar'
                ")
            ->join('countries'      ,'country_id'    ,'=','countries.id')
            ->join('governorates'   ,'governorate_id','=','governorates.id')
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
                                $query->whereNotNull('areas.area_id');
                        }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('areas.area_id')
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

