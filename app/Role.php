<?php
namespace Ultraware\Roles\Models;

use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;
use Ultraware\Roles\Traits\RoleHasRelations;
use Illuminate\Support\Facades\Route;
use Ultraware\Roles\Traits\Slugable;

class Role extends Model implements RoleHasRelationsContract
{
    use Slugable, RoleHasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'level'];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }
    public $dataTable= [
        'id'                    => array('search_type'=>'equal'         , 'query_value'=>'id'          , 'query_as'=>'id'),
        'name'                  => array('search_type'=>'equal'         , 'query_value'=>'name'        , 'query_as'=>'name'),
        'slug'                  => array('search_type'=>'equal'         , 'query_value'=>'slug'        , 'query_as'=>'slug'),
        'level'                 => array('search_type'=>'equal'         , 'query_value'=>'level'       , 'query_as'=>'level'),
        'description'           => array('search_type'=>'equal'         , 'query_value'=>'description' , 'query_as'=>'description'),
    ];
    public $createAdmin= [
            'name'          => array('type'=>'text'    ,'value' =>'','required'=>'required'),
            'slug'          => array('type'=>'text'    ,'value' =>'','required'=>'required'),
            'level'         => array('type'=>'number'  ,'value' =>'','maxlength'=>2,'required'=>'required'),
            'description'   => array('type'=>'textarea','value' =>'','size'=>'30x1','required'=>'NO')
    ];
    public $editAdmin= [
            'name'          => array('type'=>'text'    ,'value' =>'','required'=>'required'),
            'slug'          => array('type'=>'text'    ,'value' =>'','required'=>'required'),
            'level'         => array('type'=>'number'  ,'value' =>'','maxlength'=>2 ,'required'=>'required'),
            'description'   => array('type'=>'textarea','value' =>'','size'=>'30x1','required'=>'NO')
    ];
    public function getAllPermission(){
        $routeList  = Route::getRoutes();
        $Route      = [];
        foreach ($routeList as $value){ 
            $model = substr($value->getName(), 0, strpos($value->getName(), "."));
            if($model == 'debugbar' || $model =='password'){
            }else{
                $Route[$value->getName()] = $model;
            }
        }
        $Route = array_filter($Route); 
        return   $Route;
        // $Route[$value->getName()] = strstr($value->getName(), '.');
        // echo $value->getActionName().'<br/>';   
        // echo $value->getActionMethod().'<br/>';
    }
    public function getSelectedPermission(){
        // return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
        return $this->belongsToMany('Ultraware\Roles\Models\Permission', 'permission_role','role_id','permission_id');
    }
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
