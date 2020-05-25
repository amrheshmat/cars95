<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = ['phone_number','message','sms_result','created_by'];
    /**
     * The attributes that for dataTable.
     *
     * @var array
     */
    public $dataTable= [
        'id'            => array('search_type'=>'equal' , 'query_value'=>'id'           , 'query_as'=>'id'),
        'phone_number'  => array('search_type'=>'equal' , 'query_value'=>'phone_number' , 'query_as'=>'phone_number'),
        'message'       => array('search_type'=>'like' , 'query_value'=>'message'      , 'query_as'=>'message'),
        'result_name'   => array('search_type'=>'getAllList' , 'query_value'=>'sms.description'   , 'query_as'=>'result_name','name'=>'sms--description','extra_value'=> array('model'=>'Sms','index'=>'description','value'=>'description')),
    ];
    public $editAdmin= [
            'sms_result'      => array('type'=>'list','value' =>'','required'=>'required'),
            'phone_number'     => array('type'=>'text','value' =>'','required'=>'required'),
            'message'          => array('type'=>'textarea','value' =>'','required'=>'required','size'=>'2x4','colmd'=>'col-md-12'),
        ];

    public function sms_message()   { return $this->hasOne('\App\Sms'); }
    public function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw("
            sms_logs.*,
            sms.description as result_name
            ")
            ->leftjoin('sms'   ,'sms.sms_result'   ,'=','sms_logs.sms_result')
            ->Where(function ($query) use ($columns) {
                if(!empty($columns) and $columns != null) {
                    foreach ($columns as $keys=>$values) {
                        if ($values['type'] == 'like' ) {
                            $query->whereRaw($keys.' like "%'.$values['value'].'%"');
                        }elseif ($values['type'] == 'datatime') {
                            $datatime = explode(' - ', $values['value']);
                            $query->whereBetween($keys, [$datatime[0], $datatime[1]]);
                        }elseif ($values['type'] == 'ENUM' || $values['type'] == 'getAllList') {
                            $query->whereIn($keys, $values['value']);
                        }elseif ($values['type'] == 'FIND_IN_SET') {
                            $query->whereRaw($keys.'= "'.implode("",$values['value']).'"');
                        }elseif ($values['type'] == 'Having') {
                            // $query->whereRaw($keys.'>= "'.$values['value'].'"');
                        }else{
                            $query->whereRaw($keys.'= "'.$values['value'].'"');
                        }
                    }
                }else{
                    $query->whereNotNull('sms_logs.id');
                }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('sms_logs.id')
            ->paginate($rows);
        }
}
