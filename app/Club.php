<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    //Main Table 
    //Table Name
        protected $fillable = ['club_desc_ar','club_desc_en','club_parent_id','club_level','club_address','governorate_id','club_logo','club_fax','captain','assistant_secretary_general','cashier','assistant_cashier','members','club_agent','secretary_general','bio','created_by','updated_by'];
    //For index 
        public $dataTable= [
            'id'                => array('search_type'=>'equal'        , 'query_value'=>'id'                , 'query_as'=>'id'),
            'club_logo'    => array('search_type'=>'img'          , 'query_value'=>'club_logo'    , 'query_as'=>'club_logo'),
            'club_desc_ar' => array('search_type'=>'like'         , 'query_value'=>'club_desc_ar' , 'query_as'=>'club_desc_ar'),
            'club_desc_en' => array('search_type'=>'like'         , 'query_value'=>'club_desc_en' , 'query_as'=>'club_desc_en'),
            'club_address' => array('search_type'=>'like'         , 'query_value'=>'club_address' , 'query_as'=>'club_address'),
        ];
    //Create Country 
        public $createAdmin= [
            'club_logo'    => array('type'=>'file'    ,'value' => '','required'=>'required','colmd'=>'col-md-12'),
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
            'club_logo'    => array('type'=>'file','value' =>'','required'=>'no','colmd'=>'col-md-12'),
            'club_desc_ar' => array('type'=>'text','value' =>'','required'=>'required'),
            'club_desc_en' => array('type'=>'text','value' =>'','required'=>'required'),
            'governorate_id'    => array('type'=>'list','value' =>'','required'=>'required'),
            'club_address' => array('type'=>'text','value' =>'','required'=>'required'),
            'club_fax'     => array('type'=>'number','value' =>'','required'=>'required','maxlength'=>'15'),
            'captain'           => array('type'=>'text','value' =>'','required'=>'required'),
            'club_agent'   => array('type'=>'text','value' =>'','required'=>'required'),
            'secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),            
            'cashier'           => array('type'=>'text','value' =>'','required'=>'required'),            
            'assistant_secretary_general' => array('type'=>'text','value' =>'','required'=>'required'),
            'assistant_cashier' => array('type'=>'text','value' =>'','required'=>'required'),
            'members'           => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x2'),
            'bio'               => array('type'=>'textarea','value' =>'','required'=>'no','size'=>'2x4','colmd'=>'col-md-12'),
        ];
    //Edit Country 
        public $editAdmin= [
            'club_logo'    => array('type'=>'file','value' =>'','required'=>'no','colmd'=>'col-md-12'),
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

    //Relationship
    public function subclubs() { return $this->hasMany('\App\Subclub'); }
    public function phones()        { return $this->morphMany('\App\clubPhone', 'club'); }
    public function emails()        { return $this->morphMany('\App\clubEmail', 'club'); }
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


