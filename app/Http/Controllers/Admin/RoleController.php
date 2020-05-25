<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;
use Illuminate\Http\Request;
use Auth;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model  = new Role;
        $datatable  = $model::getDataTable('id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Admin.'.Role.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model  = new Role;
        $method     = 'create';
        $action     = 'Role.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Admin.'.Role.create',compact('model','method','action','modelCreator','colmd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, ['name'=>'required','level'=>'required','slug'=>'required|unique:roles,slug']);
        $request->request->add(['created_by' => Auth::user()->id]);
        $permissions = array();
        foreach ($request->permissions as $key => $value) {
            $model = substr($key, 0, strpos($key, "."));
            $getid = Permission::firstOrCreate(['slug' => $key], [ 'name' => $key, 'slug' => $key,'model'=> $model]);
            $permissions[$getid->id] = $getid->id;            
        };
        $role = Role::create($request->except('permissions'));
        $role->attachPermission($permissions);
        return redirect()->route('Role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        if($request->ajax()){
            $model    = new Role;
            $model   = Role::find($id);
            $method     = 'edit';
            $action     = 'Role.update';  
            $modelShower= $model->createAdmin;
            return view(Admin.'.Role.show',compact('model','method','action','modelShower'));
        }else{
            return redirect()->route('Role.index');
        }
    }
    
    
            
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model      = new Role;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'Role.update';
        $modelEditor= $model->editAdmin;
        return view(Admin.'.Role.edit',compact('model','method','action','modelEditor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, ['name'=>'required','level'=>'required','slug'=>'required|unique:roles,slug,'.$id,]);
        $request->request->add(['updated_by' => Auth::user()->id]);
        $permissions = array();
        foreach ($request->permissions as $key => $value) {
            $model = substr($key, 0, strpos($key, "."));
            $getid = Permission::firstOrCreate(['slug' => $key], [ 'name' => $key, 'slug' => $key,'model'=> $model]);
            $permissions[$getid->id] = $getid->id;            
        };
        $role   = Role::find($id);
        $update = $role->update($request->except('permissions'));
        $role->syncPermissions($permissions);
        return redirect()->route('Role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Role::whereId($id)->delete($id);
        return Response()->json($id);
    }
    

}
