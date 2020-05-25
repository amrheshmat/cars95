<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Covid19 extends Model
{
    
    //Main Table 
    //Table Name
    protected $primaryKey = 'id'; // or null
    protected $fillable = ['OldRefID','phone','approval_number','type_of_injury','job','job_destination','treatment_destination','treatment_destination_address','family_number','desc_of_injury','approval_image'];
    //For index 
        public $dataTable= [
            'id'            => array('search_type'=>'equal' , 'query_value'=>'id', 'query_as'=>'id'),
            'OldRefID'        => array('search_type'=>'like' , 'query_value'=>'covid19s.OldRefID'    , 'query_as'=>'OldRefID'),
            'family_number'        => array('search_type'=>'like' , 'query_value'=>'covid19s.family_number'    , 'query_as'=>'family_number'),
            'treatment_destination'      => array('search_type'=>'like' , 'query_value'=>'treatment_destination', 'query_as'=>'treatment_destination'),
            'type_of_injury' => array('search_type'=>'equal' , 'query_value'=>'type_of_injury', 'query_as'=>'type_of_injury'),
           'job' => array('search_type' => 'equal','query_value'=>'job','query_as'=>'job'),
          'job_destination' =>  array('search_type' => 'equal','query_value'=>'job_destination','query_as'=>'job_destination'),
           //'status_name'           => array('search_type'=>'getAllList'  ,'query_value'=>'status'     ,'query_as'=>'statusName','name'=>'statuses--name','extra_value'=> array('model'=>'statuses','index'=>'name','value'=>'id')),
            'request_SDate'         => array('search_type'=>'datatime'       , 'query_value'=>'covid19s.created_at'    , 'query_as'=>'created_at'),
            // 'request_LDate'         => array('search_type'=>'datatime'       , 'query_value'=>'medical_requests.updated_at'      , 'query_as'=>'requests_updated_at'),
        ];
    //Create Country 
        public $createAdmin= [
            // 'club_logo'    => array('type'=>'file'    ,'value' => '','required'=>'required','colmd'=>'col-md-12'),
            'club_desc_ar' => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'club_desc_en' => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'governorate_id'    => array('type'=>'list','value' =>'','required'=>'required'),
            'club_address' => array('type'=>'text','value' =>'','required'=>'required'),
            'club_fax'     => array('type'=>'number','value' =>'','required'=>'required','maxlength'=>'15'),
            'captain'           => array('type'=>'text','value' =>'','required'=>'required'),
            'club_agent'   => array('type'=>'text','value' =>'','required'=>'required'),
            'secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),            
            'cashier'           => array('type'=>'text','value' =>'','required'=>'required'),            
            'assistant_secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),
            'assistant_cashier' => array('type'=>'text','value' =>'','required'=>'required'),
            'members'           => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
            'bio'               => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2','colmd'=>'col-md-12'),
        ];
    
    //Edit Country 
        public $showAdmin= [
            'request_id'    => array('type'=>'text','value' =>'','required'=>'required'),            
            'name'          => array('type'=>'text','value' =>'','required'=>'required'),
            'phone'         => array('type'=>'text','value' =>'','required'=>'required'),
            'club_user_number' => array('type'=>'text','value' =>'','required'=>'required'),            
            'status'                => array('type'=>'list'     ,'value' =>'','required'=>'required'),
            'created_at'    => array('type'=>'datetime' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),
        ];
    //Edit Country 
        public $editAdmin= [
            'request_id'    => array('type'=>'text','value' =>'','required'=>'required'),            
            'name'          => array('type'=>'text','value' =>'','required'=>'required'),
            'club_user_number' => array('type'=>'text','value' =>'','required'=>'required'),
            'status'=> array('type'=>'text','value' =>'','required'=>'required'),
            'provider_type_id'=> array('type'=>'list2'     ,'value' =>'','required'=>'No')
        ];

    //Relationship
    public function MedicalServiceProviderType()
       {return $this->belongsTo('App\MedicalServiceProviderType','provider_type_id','id');}
        public function Status(){        return $this->hasOne('App\Status','id','status');}
        // public function MedicalRequests() { return $this->hasMany('\App\MedicalRequest'); }
        public function statuses(){return $this->belongsTo('App\statuses','status','id');}
       // public function statuses(){return $this->belongsTo('App\statuses','status','id');}
        // public function phones()        { return $this->morphMany('\App\clubPhone', 'club'); }
        // public function emails()        { return $this->morphMany('\App\clubEmail', 'club'); }
    function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
        return $query->selectRaw("
                covid19s.*                  
            ")
        ->Where(function ($query) use ($columns) 
                {
                    if(!empty($columns) and $columns != null) {
                        foreach ($columns as $keys => $values) {
                            if ($values['type'] == 'like') {
                                $query->whereRaw($keys.' like "%'.$values['value'].'%"');
                            }elseif ($values['type'] == 'datatime') {
                                $datatime = explode(' - ', $values['value']);
                                $query->whereBetween($keys, [$datatime[0], $datatime[1]]);
                            }elseif ($values['type'] == 'ENUM' || $values['type'] == 'getAllList' ) {
                                $query->whereIn($keys, $values['value']);
                                // $query->whereRaw($keys.' in ('.implode("",$values['value']).')');
                            }else{
                                $query->whereRaw($keys.'= "'.$values['value'].'"');
                            }
                        }
                    }else{
                            $query->whereNotNull('covid19s.id');
                    }
        })
        ->orderBy($orderby,$ordertype)
        ->groupBy('covid19s.id')
        ->paginate($rows);
    }
   
}
