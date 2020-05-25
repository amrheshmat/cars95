<?php

namespace App\Http\Controllers\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedicalRequest;
use App\MedicalRequestDoc;
use App\statuses;
use App\helper\Notification;
use App\OrganizationMember;
use Auth;
use DB;
use File;
use Image;




class MedicalRequestController extends Controller
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
        $model          = new \App\MedicalRequest;
        $method         = 'create';
        $action         = 'MedicalRequest.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Medical.'.MedicalRequest.create',compact('model','method','action','modelCreator','colmd'));
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
        return redirect()->route('MedicalRequest.index');
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
        if($request->ajax()){
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
        $model      = new \App\MedicalRequest;
        $model      = $model::find($id);
        if($model->view_by > 0 && Auth::user()->id){

        }else{

        }
        $method     = 'edit';
        $action     = 'MedicalRequest.update';
        $modelEditor= $model->editAdmin;
        $docs = MedicalRequestDoc::where('medical_request_id',$id)->get();        
        return view(Medical.'.MedicalRequest.edit',compact('model','method','action','modelEditor','docs'));
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
        $this->validate($request, 
        [
            'status'=>'required',
            'approval_image' => 'image|max:3000|required_if:status,1',
            ]
        );
        $medical_request = MedicalRequest::find($id);
        $medical_request->updated_by = $user_id = Auth::user()->id;
        $update          = $medical_request->update($request->except('approval_image'));
        $users = OrganizationMember::where('mobile',$medical_request->phone)->get();
        for($i=0;$i<count($users);$i++){$token[$i] = $users[$i]['mobile_token'];}        
        if($request->status == 1){            
            $message    = "تم قبول طلب الخدمة الطبية ورقم الموافقة".$request->approval_number;
            Notification::pushNotification($token,"نقابتى : الخدمات الطبية",$message,$id,1);
        }else if($request->status == 2){            
            $message    = "نقابتى : تم رفض طلبكم";
            // Notification::pushNotification($token,$id,$message,$id,$id);
            Notification::pushNotification($token,"نقابتى : الخدمات الطبية",$message,$id,1);
        }
        if(!empty($request->file('approval_image')))
        {
            //Check picture path exists or not
            if(File::exists(public_path('/upload/MedicalRequests/'.$id)) == false )
            {
                File::makeDirectory(public_path('/upload/MedicalRequests/'.$id.'/',0777,true));
            }
            // img
            $picture    = Image::make($request->file('approval_image'));
            $imagLink   = '/upload/MedicalRequests/'.$id.'/'.time().'.'.$request->approval_image->getClientOriginalExtension();
            $picture->save(public_path().$imagLink,50);
            $medical_request->approval_image = $imagLink;
            $medical_request->save();
        }
        $request->session()->flash('message', $message);
        return redirect()->route('MedicalRequest.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        return Response()->json(trans('neqabty.notallowtodelete'),400);
        // \App\MedicalRequest::where('request_id',$id)->delete($id);        
        // return Response()->json($id);
    }
 
   
}
