<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddPropertyRequest extends Model
{
    protected $primaryKey = 'id'; // or null
    //Columns Name
        protected $fillable = ['property_name','property_type','property_price','property_space','property_describtion','attachments'];
    //For index 
    //protected $table = "add_property_requests";
    //For index 
    public $dataTable= [
        'request_id'            => array('search_type'=>'equal' , 'query_value'=>'request_id', 'query_as'=>'request_id'),
        'requester_name'        => array('search_type'=>'like' , 'query_value'=>'medical_requests.name'                 , 'query_as'=>'requester_name'),
        // 'phone'                 => array('search_type'=>'like' , 'query_value'=>'phone', 'query_as'=>'phone'),
        'club_user_number' => array('search_type'=>'equal' , 'query_value'=>'club_user_number', 'query_as'=>'club_user_number'),
       'username' => array('search_type' => 'equal','query_value'=>'username','query_as'=>'username'),
      //'provider_type_id' =>  array('search_type' => 'equal','query_value'=>'provider_type_id','query_as'=>'provider_type_id'),
       'status_name'           => array('search_type'=>'getAllList'  ,'query_value'=>'status'     ,'query_as'=>'statusName','name'=>'statuses--name','extra_value'=> array('model'=>'statuses','index'=>'name','value'=>'id')),
        'request_SDate'         => array('search_type'=>'datatime'       , 'query_value'=>'medical_requests.created_at'    , 'query_as'=>'requests_created_at'),
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
    public function Status(){        return $this->hasOne('App\Status','id','status');}
    // public function MedicalRequests() { return $this->hasMany('\App\MedicalRequest'); }
    public function statuses(){return $this->belongsTo('App\statuses','status','id');}
   // public function statuses(){return $this->belongsTo('App\statuses','status','id');}
    // public function phones()        { return $this->morphMany('\App\clubPhone', 'club'); }
    // public function emails()        { return $this->morphMany('\App\clubEmail', 'club'); }
function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
    return $query->selectRaw("
            medical_requests.*,          
        ")
    ->join('statuses'  ,'medical_requests.status','=','statuses.id')
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
                        $query->whereNotNull('medical_requests.request_id');
                }
    })
    ->orderBy($orderby,$ordertype)
    ->groupBy('medical_requests.request_id')
    ->paginate($rows);
}

}
