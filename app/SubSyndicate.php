<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubClub extends Model
{    
    //Columns Name
        protected $fillable = ['sub_club_name_ar','sub_club_name_en','sub_governorate_id','club_id','sub_club_parent_id','sub_club_level','sub_club_address','sub_club_logo','sub_club_fax','sub_captain','sub_cashier','sub_assistant_secretary_general','sub_assistant_cashier','sub_members','sub_club_agent','sub_secretary_general','sub_bio','created_by','updated_by'];
    //For index 
        public $dataTable= [
            'id'                => array('search_type'=>'equal'        , 'query_value'=>'id'                , 'query_as'=>'id'),
            // 'id_sub_club'      => array('search_type'=>'equal' , 'query_value'=>'sub_clubs.id'    , 'query_as'=>'id_sub_club'),
            'sub_club_name_ar' => array('search_type'=>'like'  , 'query_value'=>'sub_club_name_ar', 'query_as'=>'sub_club_name_ar'),
            'sub_club_name_en' => array('search_type'=>'like'  , 'query_value'=>'sub_club_name_en', 'query_as'=>'sub_club_name_en'),
        ];
    //For Create
        public $createAdmin= [
            'sub_club_logo'    => array('type'=>'file'    ,'value' => '','required'=>'required','colmd'=>'col-md-12'),
            'club_id'      => array('type'=>'list','value' =>'','required'=>'required','colmd'=>'col-md-12'),
            'sub_club_name_ar' => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'sub_club_name_en' => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'sub_governorate_id'    => array('type'=>'list','value' =>'','required'=>'required'),
            'sub_club_address' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_club_fax'     => array('type'=>'number','value' =>'','required'=>'required','maxlength'=>'15'),
            'sub_captain'           => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_club_agent'   => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),            
            'sub_cashier'           => array('type'=>'text','value' =>'','required'=>'required'),            
            'sub_assistant_secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_assistant_cashier' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_members'           => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            'sub_bio'               => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
        ];
    //For show
        public $showAdmin= [
           'sub_club_logo'    => array('type'=>'file'    ,'value' => '','required'=>'required','colmd'=>'col-md-12'),
            'club_id'      => array('type'=>'list','value' =>'','required'=>'required'),
            'sub_club_name_ar' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_club_name_en' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_governorate_id'    => array('type'=>'list','value' =>'','required'=>'required'),
            'sub_club_address' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_club_fax'     => array('type'=>'number','value' =>'','required'=>'required','maxlength'=>'15'),
            'sub_captain'           => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_club_agent'   => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),            
            'sub_cashier'           => array('type'=>'text','value' =>'','required'=>'required'),            
            'sub_assistant_secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_assistant_cashier' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_members'           => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x4','colmd'=>'col-md-12'),
            'sub_bio'               => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x4','colmd'=>'col-md-12'),
        ];
        //For Edit
        public $editAdmin= [
            'sub_club_logo'    => array('type'=>'file'    ,'value' => '','required'=>'no','colmd'=>'col-md-12'),
            'club_id'      => array('type'=>'list','value' =>'','required'=>'required','colmd'=>'col-md-12'),
            'sub_club_name_ar' => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'sub_club_name_en' => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'sub_governorate_id'    => array('type'=>'list','value' =>'','required'=>'required'),
            'sub_club_address' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_club_fax'     => array('type'=>'number','value' =>'','required'=>'required','maxlength'=>'15'),
            'sub_captain'           => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_club_agent'   => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),            
            'sub_cashier'           => array('type'=>'text','value' =>'','required'=>'required'),            
            'sub_assistant_secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_assistant_cashier' => array('type'=>'text','value' =>'','required'=>'required'),
            'sub_members'           => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            'sub_bio'               => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
        ];
        //relationShip
        public function club()     { return $this->belongsTo('\App\Subclub'); }
        public function phones()        { return $this->morphMany('\App\clubPhone', 'club'); }
        public function emails()        { return $this->morphMany('\App\clubEmail', 'club'); }
    // Helper Query 
        function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw("*")
            // ->join('clubs'     ,'club_id'     ,'=','clubs.id')
            // ->join('governorates'   ,'sub_clubs.governorate_id'   ,'=','governorates.id')


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
                                $query->whereNotNull('sub_clubs.id');
                        }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('sub_clubs.id')
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
