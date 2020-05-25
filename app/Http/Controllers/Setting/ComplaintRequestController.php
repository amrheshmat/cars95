<?php
namespace App\Http\Controllers\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ComplaintRequest;
use App\statuses;
use App\helper\Notification;
use App\OrganizationMember;
use Auth;
use DB;
use File;
use Image;
class ComplaintRequestController extends Controller
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
        
         $model      = new \App\ComplaintRequest; 
        $datatable  = $model::getDataTable('complaint_requests.id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-12';
        return view(Setting.'.Complaints.ComplaintRequest.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model          = new \App\ComplaintRequest;
        $method         = 'create';
        $action         = 'ComplaintRequest.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Setting.'.Complaints.ComplaintRequest.create',compact('model','method','action','modelCreator','colmd'));
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
        return redirect()->route('ComplaintRequest.index');
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
            $model      = new \App\ComplaintRequest;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'ComplaintRequest.update';
            $modelShower= $model->showAdmin;  
            $colmd      = 'col-md-4';
            $status     = \App\Status::pluck('name','id')->toArray();
            return view(Setting.'.Complaints.ComplaintRequest.show',compact('showData','model','method','action','modelShower','colmd','status'));
        }else{
            return redirect()->route('ComplaintRequest.index');
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
        $model      = new \App\ComplaintRequest;
         $model2 = new \App\User;
        $model      = $model::find($id);
        $method     = 'edit';
        $action     = 'ComplaintRequest.update';
        $modelEditor= $model->editAdmin;
          return view(Setting.'.Complaints.ComplaintRequest.edit',compact('model','method','action','modelEditor'));   
      
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
      
        $medical_request = ComplaintRequest::find($id);
        for($i=0;$i<count($users);$i++){$token[$i] = $users[$i]['mobile_token'];}        
        if($request->status == 1){            
            $message    = "تم قبول طلب الخدمة الطبية ورقم الموافقة".$request->approval_number;
            Notification::pushNotification($token,"نقابتى : الخدمات الطبية",$message,$id,1);
        }else if($request->status == 2){            
            $message    = "نقابتى : تم رفض طلبكم";
            // Notification::pushNotification($token,$id,$message,$id,$id);
            Notification::pushNotification($token,"نقابتى : الخدمات الطبية",$message,$id,1);
        }
     
        $request->session()->flash('message', $message);
        return redirect()->route('ComplaintRequest.index');
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
 //        
