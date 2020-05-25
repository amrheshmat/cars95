<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use File;
use Image;
use Hash;
use App\User;
use App\Log;
/*  
    use DB;
*/
class LogController extends Controller
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
        
        $model      = new \App\Log;
        $datatable  = $model::getDataTable('logs.id','desc','10');
        $tableDesign= $model->dataTable;
        $class      ="col-md-8 col-md-push-2";
        return view(Admin.'.Log.index',compact('model','class','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        /*$model          = new \App\User;
        $syndicates      = new \App\Syndicate;
        $method         = 'create';
        $action         = 'User.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        $syndicate_id  = \App\Syndicate::pluck('syndicate_desc_ar','id')->toArray();
        $provider_type_id  = \App\MedicalServiceProviderType::pluck('provider_type_ar','provider_type_ar')->toArray();
        return view(Admin.'.User.create',compact('model','method','action','modelCreator','colmd','syndicate_id','provider_type_id'));
   */ }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       /* $permission   = \App\User::findOrFail(Auth::User()->id);
        $this->validate($request, ['picture' => 'image|max:3000','first_name'=>'required','password'=>'required','email'=>'required|unique:users,email','username'=>'required|unique:users,username',
        'roles'=>'required','provider_type_id'=>'','provider_id' =>'']);
        $role = $request->provider_type_id ;
        $role  = implode(' ', $role);
        $user1 = new User;
        $user1->provider_id =  $request->provider_id ; 
       if($permission->hasRole('superprovider')){
           $user1->parent_id =  $request->parent_id ; 
       }else{
           $user1->parent_id = $request->provider_id ; 
       }
        
        $user1->provider_type_id = $role ;
        $request->request->add(['created_by' => Auth::user()->id,'provider_type_id'=>$role,'provider_id'=>$request->provider_id,'name' => $request->first_name.' '.$request->last_name]);
        $user = User::create($request->except('roles'));

        $user->attachRole($request->roles);
        // @$user->Ip_belongsToMany()->attach($request->Ip_belongsToMany);
        $userId = $user->id;
       
      // echo $user1->provider_type_id;
        //picture
        /*$user->Callcenter_belongsToMany()->attach($request->Callcenter_belongsToMany);
        if(!empty($request->file('picture'))){
            //Check picture path exists or not
            if(File::exists(public_path('/upload/User/'.$userId)) == false ){
                File::makeDirectory(public_path('/upload/User/'.$userId,0777,true));
            }
            $picture = Image::make($request->file('picture'));
            $picture->resize(160, null, function ($constraint) {$constraint->aspectRatio();});
            $picture->save(public_path().'/upload/User/'.$userId.'/profile.jpg',50);
            
            $user->picture = '/upload/User/'.$userId.'/profile.jpg';
            $user->save();
        }
       // $_response['status_message_en'] =$user->provider_type_id;
                      // return response()->json($_response, 200);
                      
                     
        return redirect()->route('User.index');*/
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
       /* if($request->ajax()){
            $model    = new \App\User;
            $showData   = \App\USer::find($id);
            $modelShower= $model->createAdmin;
            return view(Admin.'.User.show',compact('showData','model','modelShower'));
        }else{
            return redirect()->route('User.index');
        }
   */ }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
       /* $model      = new \App\User;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'User.update';
        $modelEditor= $model->editAdmin;
        $colmd      = 'col-md-4';
        $syndicate_id  = \App\Syndicate::pluck('syndicate_desc_ar','id')->toArray();
        $provider_type_id  = \App\MedicalServiceProviderType::pluck('provider_type_ar','provider_type_ar')->toArray();
        return view(Admin.'.User.edit',compact('model','method','action','modelEditor','colmd','syndicate_id','provider_type_id'));
   */ }

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
       /* $user   = \App\User::find($id);
        $role = $request->provider_type_id;
        $role  = implode(' ', $role);
        $user->provider_type_id = $role;
        echo   $user->provider_type_id;
        $this->validate($request, ['picture' => 'image|max:3000','first_name'=>'required','roles'=>'required','activated'=>'required','email'=>'unique:users,email,'.$id,'username'=>'unique:users,username,'.$id,]);
        $request->request->add(['name' => $request->first_name.' '.$request->last_name ]);
        $request->request->add(['updated_by' => Auth::user()->id,'provider_type_id'=>$role,'name' => $request->first_name.' '.$request->last_name]);
        
        $update = $user->update($request->all());
        $user->syncRoles($request->roles);
        /*$user->Callcenter_belongsToMany()->sync($request->Callcenter_belongsToMany);
        $user->Ip_belongsToMany()->sync($request->Ip_belongsToMany);

        if(!empty($request->file('picture'))){
            //Check picture path exists or not
            if(File::exists(public_path('/upload/User/'.$id)) == false ){
                File::makeDirectory(public_path('/upload/User/'.$id,0777,true));
            }
            $picture = Image::make($request->file('picture'));
            $picture->resize(160, null, function ($constraint) {$constraint->aspectRatio();});
            $picture->save(public_path().'/upload/User/'.$id.'/profile.jpg',50);
            $user->picture = '/upload/User/'.$id.'/profile.jpg';
            
            $user->save();
        }

        return redirect()->route('User.index');*/
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
      /*  \App\User::whereId($id)->delete($id);
        return Response()->json($id);*/
    }
        /*
    public function changePassword(){
        return view('auth.passwords.change');
    }
   
     public function changePasswordPost(Request $request){
        $this->validate($request, ['current_password' => 'passwordNotSame','password'      => 'required|confirmed',]);
        $User   = \App\User::find(Auth::user()->id)->update(['password'     =>$request->password,]);
        return Response()->json(array('message'=>'success','type'=>'green','title'=>'Success','icon'=>'fa fa-check','content'=>'Your data has been submitted successfully'));
    }
*/
}