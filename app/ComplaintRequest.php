<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ComplaintRequest extends Model

{
    //Main Table 
    //Table Name
    protected $primaryKey = 'id'; // or null
    protected $fillable = ['id','name','phone','status','describtion','email','created_at'];
    //For index 
        public $dataTable= [
            'id'    => array('search_type'=>'equal' , 'query_value'=>'id', 'query_as'=>'id'),
            'name' => array('search_type'=>'like','query_value'=>'complaint_requests.name', 'query_as'=>'name'),
            'email' => array('search_type'=>'like','query_value'=>'complaint_requests.email', 'query_as'=>'email'),
            'status_name'    => array('search_type'=>'getAllList'  ,'query_value'=>'status'     ,'query_as'=>'statusName','name'=>'statuses--name','extra_value'=> array('model'=>'statuses','index'=>'name','value'=>'id')),
            // 'phone' => array('search_type'=>'like','query_value'=>'phone', 'query_as'=>'phone'),
            //'details'=> array('search_type'=>'like','query_value'=>'details', 'query_as'=>'details'),
           ];
    //Create Country 
        public $createAdmin= [
             'name'           => array('type'=>'text','value' =>'','required'=>'required'),
             'phone'     => array('type'=>'number','value' =>'','required'=>'required','maxlength'=>'15'),
             'status_name'    => array('type'=>'list','value' =>'','required'=>'required'),
             'describtion' => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-6'),
             'email' => array('type'=>'text','value' =>'','required'=>'required'),
             ];
    
    //Edit Country 
        public $showAdmin= [
            'id'    => array('type'=>'text','value' =>'','required'=>'required'),            
             'name'          => array('type'=>'text','value' =>'','required'=>'required'),
             'phone' => array('type'=>'text','value' =>'','required'=>'required'),  
             'status'    => array('type'=>'text' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),         
             'describtion'   => array('type'=>'text'     ,'value' =>'','required'=>'required'),
             'email'  => array('type'=>'text','value' =>'','required'=>'required'),
             ];
    //Edit Country 
        public $editAdmin= [
            'id'    => array('type'=>'text','value' =>'','required'=>'required'),            
             'name'          => array('type'=>'text','value' =>'','required'=>'required'),
             'phone' => array('type'=>'text','value' =>'','required'=>'required'),  
             'status'    => array('type'=>'text' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),         
             'describtion'   => array('type'=>'text'     ,'value' =>'','required'=>'required'),
             'email'  => array('type'=>'text','value' =>'','required'=>'required'),
        ];

    //Relationship
        public function Status(){        return $this->hasOne('App\Status','id','status');}
        // public function MedicalRequests() { return $this->hasMany('\App\MedicalRequest'); }
        public function statuses(){return $this->belongsTo('App\statuses','status','id');}
        // public function phones()        { return $this->morphMany('\App\SyndicatePhone', 'syndicate'); }
        // public function emails()        { return $this->morphMany('\App\SyndicateEmail', 'syndicate'); }
    function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
        return $query->selectRaw("
        complaint_requests.*,                    
        complaint_requests.id as `id`,
        complaint_requests.name as `name`,
         statuses.name as 'statusName'
                
            ")
        ->join('statuses'  ,'complaint_requests.status','=','statuses.id')
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
                            $query->whereNotNull('complaint_requests.id');
                    }
        })
        ->orderBy($orderby,$ordertype)
        ->groupBy('complaint_requests.id')
        ->paginate($rows);
    }
}

/*
{
    public $timestamps = false;
    protected $table = "complaint_requests";  
    protected $primaryKey = 'id';
     protected $fillable = ['id','complaint_type','name','phone','details','status','created_at'];
    
        //Main Table 
    
    //For index 
    public $dataTable= [
        'id'    => array('search_type'=>'' , 'query_value'=>'id', 'query_as'=>'id'),
        'complaint_type' => array('search_type'=>'like','query_value'=>'complaint_type', 'query_as'=>'complaint_type'),
        'name' => array('search_type'=>'like','query_value'=>'name', 'query_as'=>'name'),
        // 'phone' => array('search_type'=>'like','query_value'=>'phone', 'query_as'=>'phone'),
        //'details'=> array('search_type'=>'like','query_value'=>'details', 'query_as'=>'details'),
        'status_name'    => array('search_type'=>'getAllList'  ,'query_value'=>'status'     ,'query_as'=>'statusName','name'=>'statuses--name','extra_value'=> array('model'=>'statuses','index'=>'name','value'=>'id')),
    ];
        //Create Country 
        public $createAdmin= [
             'details' => array('type'=>'text','value' =>'','required'=>'required','colmd'=>'col-md-6'),
            'status_name'    => array('type'=>'list','value' =>'','required'=>'required'),
             'complaint_type' => array('type'=>'text','value' =>'','required'=>'required'),
             'phone'     => array('type'=>'number','value' =>'','required'=>'required','maxlength'=>'15'),
             'name'           => array('type'=>'text','value' =>'','required'=>'required'),
            ];
    
    //Edit Country 
        public $showAdmin= [
             'id'    => array('type'=>'text','value' =>'','required'=>'required'),            
             'name'          => array('type'=>'text','value' =>'','required'=>'required'),
             'complaint_type'         => array('type'=>'text','value' =>'','required'=>'required'),
             'phone' => array('type'=>'text','value' =>'','required'=>'required'),            
             'details'   => array('type'=>'text'     ,'value' =>'','required'=>'required'),
             'status_name'    => array('type'=>'list' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),
        ];
        public $editAdmin= [
            'id'    => array('type'=>'text','value' =>'','required'=>'required'),            
            'name'          => array('type'=>'text','value' =>'','required'=>'required'),
            'complaint_type'         => array('type'=>'text','value' =>'','required'=>'required'),
            'phone' => array('type'=>'text','value' =>'','required'=>'required'),            
            'details'   => array('type'=>'text'     ,'value' =>'','required'=>'required'),
            'status_name'    => array('type'=>'list' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),
        ];
    public function statuses(){return $this->hasOne('App\statuses','id','status');}
     function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
        return $query->selectRaw("
                complaint_requests.*,                    
                complaint_requests.id as `id`,
                statuses.name as 'statusName'
                
            ")
        ->join('statuses'  ,'complaint_requests.status','=','statuses.id')
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
                            $query->whereNotNull('complaint_requests.id');
                    }
        })
        ->orderBy($orderby,$ordertype)
        ->groupBy('complaint_requests.id')
        ->paginate($rows);
    }
}
*/