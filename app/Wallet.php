<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['points','user_id','user_type'];
    
    public $dataTable= [
        'id'       => array('search_type'=>'equal'        , 'query_value'=>'id'        , 'query_as'=>'id'),
        'user_type'       => array('search_type'=>'like'  , 'query_value'=>'user_type'        , 'query_as'=>'user_type'),
        'user_id'  => array('search_type'=>'like'         , 'query_value'=>'user_id'   , 'query_as'=>'user_id'),
        'points'   => array('search_type'=>'like'         , 'query_value'=>'points'   , 'query_as'=>'points'),
    ];
    //Create Country 
    public $createAdmin= [
        'user_type'  => array('type'=>'text','value' =>'','required'=>'required'),
        'user_id'  => array('type'=>'text','value' =>'','required'=>'required'),
        'points'   => array('type'=>'text','value' =>'','required'=>'required'),
    ];
    //Edit Country 
    public $editAdmin= [
        'user_type'   => array('type'=>'text','value' =>'','required'=>'required'),
        'user_id'   => array('type'=>'text','value' =>'','required'=>'required'),
        'points'   => array('type'=>'text','value' =>'','required'=>'required'),
     ];
    //Relationship
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
        ->paginate($rows);
    }
    /**
     * Get wallet user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(){
        return $this->morphTo(Wallet::class);
    }
}
