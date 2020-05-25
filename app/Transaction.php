<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id','amount','status','ref_number','organization_member_id','membership_id','club_id','sub_club_id','service_id'];
    /**
     * The attributes that for dataTable.
     *
     * @var array
     */
    public $dataTable= [
        'id'            => array('search_type'=>'equal'   , 'query_value'=>'id'   , 'query_as'=>'id'),
        'service_id'    =>array('search_type'=>'equal'     , 'query_value'=>'service_id '       , 'query_as'=>'service_id'),
        'membership_id' =>array('search_type'=>'equal'     , 'query_value'=>'membership_id'       , 'query_as'=>'membership_id'),
        'amount'        => array('search_type'=>'equal'     , 'query_value'=>'amount'       , 'query_as'=>'amount'),
        'status'        => array('search_type'=>'ENUM'      , 'query_value'=>'status'       , 'query_as'=>'status','extra_value'=> array('pending'=>'pending','paid'=>'paid','rejected'=>'rejected')),
        'ref_number'    => array('search_type'=>'equal'     , 'query_value'=>'ref_number'   , 'query_as'=>'ref_number'),
        'created_at'    => array('search_type'=>'datatime'  , 'query_value'=>'created_at'   , 'query_as'=>'created_at'),
    ];

    public $showAdmin= [
            'ref_number'    => array('type'=>'text','value' =>'','required'=>'required'),
            'amount'        => array('type'=>'text','value' =>'','required'=>'required'),
            'status'        => array('type'=>'text','value' =>'','required'=>'required'),
            'created_at'    => array('type'=>'datetime' ,'value' =>'','required'=>'No','viewMode'=>'years','format'=>'YYYY-MM-DD'),
    ];
    //relationShip
        public function user(){return $this->belongsTo('\App\User');}

    // Helper Query           
        public function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw('transactions.*')
            // ->join('role_user' , 'role_user.user_id','=', 'users.id')
            // ->join('roles'     , 'role_user.role_id','=', 'roles.id')
            // ->leftjoin('clubs' , 'clubs.id','=', 'users.club_id')
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
                    $query->whereNotNull('transactions.id');
                }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('transactions.id')
            ->paginate($rows);
        }
}
