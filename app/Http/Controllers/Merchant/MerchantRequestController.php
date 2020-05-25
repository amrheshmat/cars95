<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedicalRequest;
use App\MedicalRequestDoc;
use App\statuses;
use App\helper\Notification;
use App\OrganizationMember;
use DB;
use File;
use Image;




class MerchantRequestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index()
    {
         $model      = new \App\MedicalRequest;
         $datatable  = $model::getDataTable('medical_requests.request_id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-12';
        return view(Medical.'.MedicalRequest.index',compact('model','datatable','tableDesign','class'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        /*$model          = new \App\MedicalRequest;
        $method         = 'create';
        $action         = 'MedicalRequest.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Medical.'.MedicalRequest.create',compact('model','method','action','modelCreator','colmd'));
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
      //  return redirect()->route('MedicalRequest.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
       /* if($request->ajax()){
            $model      = new \App\MedicalRequest;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'MedicalRequest.update';
            $modelShower= $model->showAdmin;  
            $colmd      = 'col-md-4';
            $status     = \App\Status::pluck('name','id')->toArray();
            return view(Medical.'.MedicalRequest.show',compact('showData','model','method','action','modelShower','colmd','status'));
        }else{
            return redirect()->route('MedicalRequest.index');
        }*/
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
        /*$model      = new \App\MedicalRequest;
         $model2 = new \App\User;
        $model      = $model::find($id);
        if($model->view_by > 0 && Auth::user()->id){

        }else{

        }
        $method     = 'edit';
        $action     = 'MedicalRequest.update';
            $modelEditor= $model->editAdmin;
        $docs = MedicalRequestDoc::where('medical_request_id',$id)->get();   
        $provider_type_id  = \App\MedicalServiceProviderType::all();
        $user   = \App\User::findOrFail(Auth::User()->id);
        $provider = array();
        if ($user->hasRole('superadmin')) {
            $users = \App\User::all();
        }else if($user->hasRole('superprovider')){
            $provider[Auth::User()->id] = Auth::User()->username;
            $subProvider_id = array(1010855,1010818,1081923);
            $users = \App\User::whereIn('provider_id',$subProvider_id)->get();
        }else if($user->hasRole('provider')){
            
            $provider[Auth::User()->id] = Auth::User()->username;
            $users = \App\User::where('provider_id',Auth::User()->provider_id)->get();
        }
        else if($user->hasRole('medical')){
            $authProvider = explode(" ",Auth::User()->provider_type_id);
            $users = \App\User::whereIn('provider_type_id',$authProvider)->get();
        }
        $amr = array();
        foreach($users as $user){
            $medical_user = \App\User::find($user->id);
        if ($medical_user->hasRole('medical')) {
            $output = \App\User::where('id',$user->id)->get();
            foreach($output as $provider){
                $amr[$provider->id] = $provider->username;
            }
          
         }
         
        }
        if($amr){
            return view(Medical.'.MedicalRequest.edit',compact('model','method','action','modelEditor','docs','provider_type_id','amr'));    
        }else if($provider ){
          return view(Medical.'.MedicalRequest.edit',compact('model','method','action','modelEditor','docs','provider_type_id','amr','provider'));   
        }else{
            return view(Medical.'.MedicalRequest.edit',compact('model','method','action','modelEditor','docs','provider_type_id')); 
        }
         
        
        */
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
       /* $this->validate($request, 
        [
            'status'=>'required',
            'approval_image' => 'max:3000|required_if:status,1',
            ]
        );
        $medical_request = MedicalRequest::find($id);
        $medical_request->updated_by  = Auth::user()->id;
        $update          = $medical_request->update($request->except('approval_image'));
        $users = OrganizationMember::where('mobile',$medical_request->phone)->get();
        for($i=0;$i<count($users);$i++){$token[$i] = $users[$i]['mobile_token'];}        
        if($request->status == 1){            
            $message    = "تم قبول طلب الخدمة الطبية ورقم الموافقة".$request->approval_number;
          //  Notification::pushNotification($token,"نقابتى : الخدمات الطبية",$message,$id,1);
        }else if($request->status == 2){            
            $message    = "نقابتى : تم رفض طلبكم";
            // Notification::pushNotification($token,$id,$message,$id,$id);
           // Notification::pushNotification($token,"نقابتى : الخدمات الطبية",$message,$id,1);
        }
        if(!empty($request->file('approval_image')))
        {
            //Check picture path exists or not
            if(File::exists(public_path('/upload/MedicalRequests/'.$id)) == false )
            {
                File::makeDirectory(public_path('/upload/MedicalRequests/'.$id.'/',0777,true));
            }
            // img
           // $picture    = Image::make($request->file('approval_image'));
            $imagLink   = '/upload/MedicalRequests/'.$id.'/'.time().'.'.$request->approval_image->getClientOriginalExtension();
           // $picture->save(public_path().$imagLink,50);
            $medical_request->approval_image = $imagLink;
            $medical_request->save();
        }
        $request->session()->flash('message', $message);
        return redirect()->route('MedicalRequest.index');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
       // return Response()->json(trans('neqabty.notallowtodelete'),400);
        // \App\MedicalRequest::where('request_id',$id)->delete($id);        
        // return Response()->json($id);
    }
 
   
}
