<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{    
    //Columns Name
        protected $fillable = ['name','governorate_id','trip_place_type_id','details','rules','map','max_persons','created_by','updated_by'];
    //For index 
        public $dataTable= [                      
            'id'             => array('search_type'=>'equal' , 'query_value'=>'places.id'      , 'query_as'=>'id_places'),
            'governorate_id_name'   =>array('search_type'=>'getAllList'  ,'query_value'=>'governorates.governorate_desc_ar'     ,'query_as'=>'governorate_id_name','name'=>'governorates--governorate_desc_ar','extra_value'=> array('model'=>'Governorate','index'=>'governorate_desc_ar','value'=>'governorate_desc_ar')),
            'name'                  => array('search_type'=>'like'  , 'query_value'=>'name', 'query_as'=>'name'),            
        ];
    //For Create
        public $createAdmin= [
            'name'              => array('type'=>'text','value' =>'','required'=>'required'),
            'governorate_id'    => array('type'=>'list','value' =>'','required'=>'required'),
            'trip_place_type_id'=> array('type'=>'list','value' =>'','required'=>'required'),
            'details'           => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            'rules'             => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            // 'map'               => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            // 'sub_syndicate_logo'    => array('type'=>'file'    ,'value' => '','required'=>'required','colmd'=>'col-md-12'),            
        ];
        public $showAdmin= [
            'name'              => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-12'),
            'governorate_id'    => array('type'=>'list','value' =>'','required'=>'required'),
            'trip_place_type_id'=> array('type'=>'list','value' =>'','required'=>'required'),
            'details'           => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            'rules'             => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            // 'map'               => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            // 'sub_syndicate_logo'    => array('type'=>'file'    ,'value' => '','required'=>'required','colmd'=>'col-md-12'),            
        ];
    //For Edit
        public $editAdmin= [
            'name'              => array('type'=>'text','value' =>'','required'=>'required'),
            'governorate_id'    => array('type'=>'list','value' =>'','required'=>'required'),
            'trip_place_type_id'=> array('type'=>'list','value' =>'','required'=>'required'),
            'details'           => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            'rules'             => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            // 'map'               => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            // 'sub_syndicate_logo'    => array('type'=>'file'    ,'value' => '','required'=>'required','colmd'=>'col-md-12'),            
        ];
    //relationShip
        public function governorate()   { return $this->hasOne('\App\Governorate'); }
        public function images()        { return $this->morphMany('\App\Image', 'model'); }
    // Helper Query 
        function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw("
            places.*,
            places.id as id_places,
            governorates.governorate_desc_ar as governorate_id_name
            ")
            // ->join('syndicates'     ,'syndicate_id'     ,'=','syndicates.id')
            ->join('governorates'   ,'places.governorate_id'   ,'=','governorates.id')
             ->Where(function ($query) use ($columns) 
                    {
                        if(!empty($columns) and $columns != null) {
                            foreach ($columns as $keys => $values) {
                                if ($values['type'] == 'like') {
                                    $query->whereRaw($keys.' like "%'.$values['value'].'%"');
                                }elseif ($values['type'] == 'ENUM' || $values['type'] == 'getAllList') {
                                    $query->whereIn($keys, $values['value']);
                                }elseif ($values['type'] == 'datatime') {
                                    $datatime = explode(' - ', $values['value']);
                                    $query->whereBetween($keys, [$datatime[0], $datatime[1]]);
                                }else{
                                    $query->whereRaw($keys.'= "'.$values['value'].'"');
                                }
                            }
                        }else{
                                $query->whereNotNull('places.id');
                        }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('places.id')
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
