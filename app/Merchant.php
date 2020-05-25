<?php


namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Authenticatable
    {
      use Notifiable;
    protected $fillable = ['username','email','password','provider_id','parent_id'];
    /*
         * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];
    /**
     * The function that should be crypt password.
     *
     * @var array
     */
    public function setPasswordAttribute($password){ 

        $this->attributes['password'] = bcrypt($password);
    }
    //For index 
    public $dataTable= [
        'username'                => array('search_type'=>'like'         , 'query_value'=>'username'        , 'query_as'=>'username'),
        'email'                => array('search_type'=>'like'         , 'query_value'=>'email'        , 'query_as'=>'email'),
        'provider_id'                => array('search_type'=>'equal'         , 'query_value'=>'provider_id'        , 'query_as'=>'provider_id'),
        
    ];
    //Create Customer 
    public $createAdmin= [
        'username'   	=> array('type'=>'text','value' =>'','required'=>'required' ),
        'email'   	=> array('type'=>'email','value' =>'','required'=>'required' ),
        'password'   	=> array('type'=>'password','value' =>'','required'=>'required' ),
        'provider_id'   	=> array('type'=>'number','value' =>'','required'=>'required','maxlength'=>9 ),
    ];
    public $editAdmin= [
        'username'    => array('type'=>'text','value' =>'','required'=>'required'),
        'email'   	=> array('type'=>'email','value' =>'','required'=>'required' ),
        'password'   	=> array('type'=>'password','value' =>'','required'=>'required' ),
        'provider_id'   	=> array('type'=>'number','value' =>'','required'=>'required','maxlength'=>9 ),
    ];
    //Relationship

    /**
     * Get user wallet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function wallet(){
        return $this->morphOne(Wallet::class,'user');
    }    
    
      // public function emails()        { return $this->morphMany('\App\SyndicateEmail', 'syndicate'); }
    function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
        return $query->selectRaw("*")
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
                            $query->whereNotNull('merchants.id');
                    }
        })
        ->orderBy($orderby,$ordertype)
        ->groupBy('merchants.id')
        ->paginate($rows);
    }
}
