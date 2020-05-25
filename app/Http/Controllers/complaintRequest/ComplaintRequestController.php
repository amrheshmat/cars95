<?php

namespace App\Http\Controllers\complaintRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ComplaintRequest;
use App\helper\Notification;
use File;
use Image;
use Auth;
use DateTime;


class ComplaintRequestController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $model      = new \App\ComplaintRequest;
        $datatable  = $model::getDataTable('complaint_requests.id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-12';
        return view(Setting.'.Complaints.complaintRequest.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $model          = new \App\MedicalRequest;
        // $method         = 'create';
        // $action         = 'MedicalRequest.store';
        // $modelCreator   = $model->createAdmin;
        // $colmd          = 'col-md-4';
        // return view(Medical.'.MedicalRequest.create',compact('model','method','action','modelCreator','colmd'));
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
        // return redirect()->route('MedicalRequest.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
         if($request->ajax()){
             $model      = new \App\tripRequest;
        //     $model      = $model::find($id);
        //     $method     = 'edit';
        //     $action     = 'tripRequest.update';
        //     $modelShower= $model->showAdmin;  
        //     $colmd      = 'col-md-4';
        //     $status     = \App\Status::pluck('name','id')->toArray();
        //     return view('tripRequest.show',compact('showData','model','method','action','modelShower','colmd','status'));
        // }else{
        //     return redirect()->route('MedicalRequest.index');
        // }
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
        $model      = new \App\tripRequest;
        $model      = $model::find($id);
        if($model->view_by > 0 && Auth::user()->id){

        }else{

        }
        $method     = 'edit';
        $action     = 'tripRequest.update';
        $modelEditor= $model->editAdmin;
        $trip = \App\Trip::find($model->trip_id);
        $docs = tripRequestDoc::where('trip_request_id',$id)->get(); 
        $regiment = TripRegiment::where('id',$model->regiment_id)->get()->first(); 
               
        return view('tripRequest.edit',compact('model','method','action','modelEditor','docs','trip','regiment'));
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
            'status'         => 'required',
            'approval_image' => 'image|max:3000',
            ]
        );
        $message = "";
        $tripRequest = tripRequest::find($id);
        // $tripRequest->updated_by = $user_id = Auth::user()->id;
        $update          = $tripRequest->update($request->except('approval_image'));
        $users = OrganizationMember::where('mobile',$tripRequest->phone)->get();
        for($i=0;$i<count($users);$i++){$token[$i] = $users[$i]['mobile_token'];}        
        if($request->status == 1){            
            $message    = "تم قبول طلب الرحلة ورقم الموافقة".$request->approval_number;
            Notification::pushNotification($token,"نقابتى : خدمات الرحلات",$message,$id,2);
        }else if($request->status == 2){            
            $message    = "نقابتى : تم رفض طلبكم";
            // Notification::pushNotification($token,$id,$message,$id,$id);
            Notification::pushNotification($token,"نقابتى : خدمات الرحلات",$message,$id,2);
        }
        if(!empty($request->file('approval_image')))
        {
            //Check picture path exists or not
            if(File::exists(public_path('/upload/TripRequests/'.$id)) == false )
            {
                File::makeDirectory(public_path('/upload/TripRequests/'.$id.'/',0777,true));
            }
            // img
            $picture    = Image::make($request->file('approval_image'));
            $imagLink   = '/upload/TripRequests/'.$id.'/'.time().'.'.$request->approval_image->getClientOriginalExtension();
            $picture->save(public_path().$imagLink,50);
            $tripRequest->approval_image = $imagLink;
            
        }
        $tripRequest->status = $request->status;
        $tripRequest->save();
        $request->session()->flash('message', $message);
        return redirect()->route('tripRequest.index');
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

    {
        $model      = new \App\tripRequest;
        $datatable  = $model::getDataTable('trips_requests.id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-12';
        return view('tripRequest.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    //     // $model          = new \App\MedicalRequest;
    //     // $method         = 'create';
    //     // $action         = 'MedicalRequest.store';
    //     // $modelCreator   = $model->createAdmin;
    //     // $colmd          = 'col-md-4';
    //     // return view(Medical.'.MedicalRequest.create',compact('model','method','action','modelCreator','colmd'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return redirect()->route('MedicalRequest.index');
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
        // if($request->ajax()){
        //     $model      = new \App\tripRequest;
        //     $model      = $model::find($id);
        //     $method     = 'edit';
        //     $action     = 'tripRequest.update';
        //     $modelShower= $model->showAdmin;  
        //     $colmd      = 'col-md-4';
        //     $status     = \App\Status::pluck('name','id')->toArray();
        //     return view('tripRequest.show',compact('showData','model','method','action','modelShower','colmd','status'));
        // }else{
        //     return redirect()->route('MedicalRequest.index');
        // }
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
        $model      = new \App\tripRequest;
        $model      = $model::find($id);
        if($model->view_by > 0 && Auth::user()->id){

        }else{

        }
        $method     = 'edit';
        $action     = 'tripRequest.update';
        $modelEditor= $model->editAdmin;
        $trip = \App\Trip::find($model->trip_id);
        $docs = tripRequestDoc::where('trip_request_id',$id)->get(); 
        $regiment = TripRegiment::where('id',$model->regiment_id)->get()->first(); 
               
        return view('tripRequest.edit',compact('model','method','action','modelEditor','docs','trip','regiment'));
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
            'status'         => 'required',
            'approval_image' => 'image|max:3000',
            ]
        );
        $message = "";
        $tripRequest = tripRequest::find($id);
        // $tripRequest->updated_by = $user_id = Auth::user()->id;
        $update          = $tripRequest->update($request->except('approval_image'));
        $users = OrganizationMember::where('mobile',$tripRequest->phone)->get();
        for($i=0;$i<count($users);$i++){$token[$i] = $users[$i]['mobile_token'];}        
        if($request->status == 1){            
            $message    = "تم قبول طلب الرحلة ورقم الموافقة".$request->approval_number;
            Notification::pushNotification($token,"نقابتى : خدمات الرحلات",$message,$id,2);
        }else if($request->status == 2){            
            $message    = "نقابتى : تم رفض طلبكم";
            // Notification::pushNotification($token,$id,$message,$id,$id);
            Notification::pushNotification($token,"نقابتى : خدمات الرحلات",$message,$id,2);
        }
        if(!empty($request->file('approval_image')))
        {
            //Check picture path exists or not
            if(File::exists(public_path('/upload/TripRequests/'.$id)) == false )
            {
                File::makeDirectory(public_path('/upload/TripRequests/'.$id.'/',0777,true));
            }
            // img
            $picture    = Image::make($request->file('approval_image'));
            $imagLink   = '/upload/TripRequests/'.$id.'/'.time().'.'.$request->approval_image->getClientOriginalExtension();
            $picture->save(public_path().$imagLink,50);
            $tripRequest->approval_image = $imagLink;
            
        }
        $tripRequest->status = $request->status;
        $tripRequest->save();
        $request->session()->flash('message', $message);
        return redirect()->route('tripRequest.index');
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
