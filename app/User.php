<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Support\Facades\Cache;
use Cache;
use DB;

class User extends Authenticatable
{
      use Notifiable, HasRoleAndPermission, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name','last_name','name','email','username','password','extension','activated','picture','lock','club_id','provider_type_id','provider_id','parent_id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];
    protected $dates  = ['deleted_at'];
    /**
     * The function that should be crypt password.
     *
     * @var array
     */
   
    /**
     * The attributes that for dataTable.
     *
     * @var array
     */
    public $dataTable= [
        // 'picture'           => array('search_type'=>'img'           , 'query_value'=>'users.picture'     , 'query_as'=>'picture'),
        'name'              => array('search_type'=>'like'         , 'query_value'=>'users.name'        , 'query_as'=>'name'),
        'username'          => array('search_type'=>'like'         , 'query_value'=>'users.username'    , 'query_as'=>'username'),
        'email'             => array('search_type'=>'like'         , 'query_value'=>'users.email'       , 'query_as'=>'email'),
        
        
        'club_name'   =>array('search_type'=>'getAllList'  ,'query_value'=>'clubs.club_desc_ar'     ,'query_as'=>'club_name','name'=>'clubs--club_desc_ar','extra_value'=> array('model'=>'club','index'=>'club_desc_ar','value'=>'club_desc_ar')),

        'activated'         => array('search_type'=>'ENUM'          , 'query_value'=>'activated'         , 'query_as'=>'activated','extra_value'=> array('1'=>'1','0'=>'0')),
        'Role'              => array('search_type'=>'ManyToMany' , 'query_value'=>'role_name', 'query_as'=>'role_name','extra_value'=>'role_name'),
        
        //'provider_type_ar'   =>array('search_type'=>'getAllList'  ,'query_value'=>'medical_service_provicer_types.provider_type_ar'     ,'query_as'=>'provider_type_ar','name'=>'medical_service_provicer_types--provider_type_ar','extra_value'=> array('model'=>'MedicalServiceProviderType','index'=>'provider_type_ar','value'=>'provider_type_ar')),
    ];

    public $createAdmin= [
            'picture'        => array('type'=>'file'    ,'value' => '','required'=>'no','colmd'=>'col-md-12'),
            'first_name'     => array('type'=>'text'    ,'value' =>'','required'=>'required'),
            'last_name'      => array('type'=>'text'    ,'value' =>'','required'=>'No'),
            'username'       => array('type'=>'text','value' =>'','required'=>'required'),
            'password'       => array('type'=>'password','value' =>'','required'=>'required'),
            'email'          => array('type'=>'email'   ,'value' =>'','required'=>'required'),
            'extension'      => array('type'=>'number'  ,'value' =>'','required'=>'No','maxlength'=>9),
            'activated'      => array('type'=>'enum'    ,'value' => array('1'=>'Active','0'=>'Disable'),'required'=>'required'),
            'roles[]'        => array('type'=>'relationship' ,'value' =>'','required'=>'required','multiple'=>'multiple'),
            
            'club_id'   => array('type'=>'list'     ,'value' =>'','required'=>'No'),
            'provider_type_id[]' => array('type'=>'relationship2','value' =>'','required'=>'','multiple'=>'multiple'),
            'provider_id'      => array('type'=>'number2'  ,'value' =>'','required'=>'No','maxlength'=>9),
        
         'parent_id'      => array('type'=>'number3'  ,'value' =>'','required'=>'No','maxlength'=>9),
            // 'Ip_belongsToMany[]'          => array('type'=>'relationship' ,'value' =>'','required'=>'No','multiple'=>'multiple'),
    ];
    
    public $editAdmin= [
        'picture'        => array('type'=>'file'    ,'value' => '','required'=>'notrequired','colmd'=>'col-md-12'),
        'first_name'     => array('type'=>'text'    ,'value' =>'','required'=>'required'),
        'last_name'      => array('type'=>'text'    ,'value' =>'','required'=>'No'),
        'username'       => array('type'=>'text'    ,'value' =>'','required'=>'required'),
        'email'          => array('type'=>'email'   ,'value' =>'','required'=>'No'),
        'extension'      => array('type'=>'number'  ,'value' =>'','required'=>'No','maxlength'=>9),
        'activated'      => array('type'=>'enum'    ,'value' => array('1'=>'Active','0'=>'Disable'),'required'=>'required'),
        'roles[]'        => array('type'=>'relationship' ,'value' =>'roles','required'=>'required','multiple'=>'multiple'),
       
        'club_id'   => array('type'=>'list'     ,'value' =>'','required'=>'No'),
        'provider_type_id[]' => array('type'=>'relationship2','value' =>'provider_type_id','required'=>'','multiple'=>'multiple'),
        'provider_id'      => array('type'=>'number2'  ,'value' =>'','required'=>'No','maxlength'=>9),
         'parent_id'      => array('type'=>'number3'  ,'value' =>'','required'=>'No','maxlength'=>9),
        // 'Ip_belongsToMany[]'          => array('type'=>'relationship' ,'value' =>'','required'=>'No','multiple'=>'multiple'),
    ];

    //New function
        public function getRolesListAttribute() { return $this->getRoles()->pluck('id','slug')->toArray(); }
        public function Role_belongsToMany()    { return $this->belongsToMany('Ultraware\Roles\Models\Role'); }
        public function Ip_belongsToMany()      { return $this->morphToMany('App\Ip', 'iprelation');}
        public function fullName()              { return $this->firstname . '  ' . $this->lastname; }
        public function isOnline(){
            return  Cache::has('user-online-'.$this->id);
        }
        //relationShip
    /*   public function MedicalServiceProviderType()
       {return $this->belongsTo('App\MedicalServiceProviderType','provider_type_id','id');}*/
        public function club(){return $this->belongsTo('App\club','club_id','id');}
    // Helper Query      
    
     public function scopeGetDataTable($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw('
            users.*,
            group_concat(roles.name , " ") as role_name,
            clubs.club_desc_ar as club_name
            ')
            ->join('role_user' , 'role_user.user_id','=', 'users.id')
            ->join('roles'     , 'role_user.role_id','=', 'roles.id')
            ->leftjoin('clubs' , 'clubs.id','=', 'users.club_id')
           // ->leftjoin('medical_service_provicer_types' ,'users.provider_type_id' ,'=','medical_service_provicer_types.id' )    
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
                    $query->whereNotNull('users.id');
                }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('users.id')
            ->paginate($rows);
        }
        public function scopeGetDataTable2($query,$orderby,$ordertype,$rows,$columns  = ''){
            return $query->selectRaw('
            users.*,
            group_concat(roles.name , " ") as role_name,
            clubs.club_desc_ar as club_name
            ')
            ->join('role_user' , 'role_user.user_id','=', 'users.id')
            ->join('roles'     , 'role_user.role_id','=', 'roles.id')
            ->leftjoin('clubs' , 'clubs.id','=', 'users.club_id')
            ->whereIn('users.extension',[1,2])
           // ->leftjoin('medical_service_provicer_types' ,'users.provider_type_id' ,'=','medical_service_provicer_types.id' )    
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
                    $query->whereNotNull('users.id');
                }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('users.id')
            ->paginate($rows);
        }
    
            public function scopeGetMedicalDataTable($query,$orderby,$ordertype,$rows,$provider_type_id,$columns  = ''){
                $provid =  explode(",",$provider_type_id);
            return $query->selectRaw('
            users.*,
            group_concat(roles.name , " ") as role_name,
            clubs.club_desc_ar as club_name
            ')
            ->join('role_user' , 'role_user.user_id','=', 'users.id')
            ->join('roles'     , 'role_user.role_id','=', 'roles.id')
            ->leftjoin('clubs' , 'clubs.id','=', 'users.club_id')
            ->where(function ($query) use ($provid ) {
                for ($i = 0; $i < count($provid); $i++){
                    $query->orwhere('users.provider_type_id', 'like',  '%' . $provid[$i] .'%');
                 } 
            })
           // ->leftjoin('medical_service_provicer_types' ,'users.provider_type_id' ,'=','medical_service_provicer_types.id' )    
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
                    $query->whereNotNull('users.id');
                }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('users.id')
            ->paginate($rows);
        }
 public function scopeGetMedicalDataTable2($query,$orderby,$ordertype,$rows,$provider_type_id,$columns  = ''){
                $provid =  explode(",",$provider_type_id);
            return $query->selectRaw('
            users.*,
            group_concat(roles.name , " ") as role_name,
            clubs.club_desc_ar as club_name
            ')
            ->join('role_user' , 'role_user.user_id','=', 'users.id')
            ->join('roles'     , 'role_user.role_id','=', 'roles.id')
            ->leftjoin('clubs' , 'clubs.id','=', 'users.club_id')
            ->where('users.provider_type_id','=','2121212')
           // ->leftjoin('medical_service_provicer_types' ,'users.provider_type_id' ,'=','medical_service_provicer_types.id' )    
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
                    $query->whereNotNull('users.id');
                }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('users.id')
            ->paginate($rows);
        }

        public function scopeGetUserProviderDataTable($query,$orderby,$ordertype,$rows,$uthProvider,$columns  = ''){
            return $query->selectRaw('
            users.*,
            group_concat(roles.name , " ") as role_name,
            clubs.club_desc_ar as club_name
            ')
            ->join('role_user' , 'role_user.user_id','=', 'users.id')
            ->join('roles'     , 'role_user.role_id','=', 'roles.id')
            ->leftjoin('clubs' , 'clubs.id','=', 'users.club_id')
            ->where('users.parent_id','=',$uthProvider)
           // ->leftjoin('medical_service_provicer_types' ,'users.provider_type_id' ,'=','medical_service_provicer_types.id' )    
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
                    $query->whereNotNull('users.id');
                }
            })
            ->orderBy($orderby,$ordertype)
            ->groupBy('users.id')
            ->paginate($rows);
        }

    /**
     * Get user wallet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function wallet(){
        return $this->morphOne(Wallet::class,'user');
    }
}
