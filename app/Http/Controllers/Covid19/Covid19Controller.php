<?php

namespace App\Http\Controllers\Covid19;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Covid19doc;
use App\OrganizationMember;
use App\helper\Notification;

class Covid19Controller extends Controller
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
        $model      = new \App\Covid19;
        $datatable  = $model::getDataTable('covid19s.id','desc','10');
        $tableDesign= $model->dataTable;
        $class      = 'col-md-12';
        return view(Covid19.'.index',compact('model','datatable','tableDesign','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       /* //
        $model          = new \App\MedicalRequest;
        $method         = 'create';
        $action         = 'MedicalRequest.store';
        $modelCreator   = $model->createAdmin;
        $colmd          = 'col-md-4';
        return view(Medical.'.MedicalRequest.create',compact('model','method','action','modelCreator','colmd'));
    */
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
        //return redirect()->route('MedicalRequest.index');
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
        /*if($request->ajax()){
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
        $model      = new \App\Covid19;
        $model      = $model::find($id);
        if($model->view_by > 0 && Auth::user()->id){

        }else{

        }
        $method     = 'edit';
        $action     = 'Covid19.update';
        $modelEditor= $model->editAdmin;
       $docs = Covid19doc::where('covid19_request_id',$id)->get();        
    return view(Covid19.'.edit',compact('model','method','action','modelEditor','docs'));
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
        
        $medical_request =  \App\Covid19::find($id);
       // $medical_request->updated_by = $user_id = Auth::user()->id;
        //$update          = $medical_request->update($request->except('approval_image'));
        $users = OrganizationMember::where('mobile',$medical_request->phone)->get();
        for($i=0;$i<count($users);$i++){$token[$i] = $users[$i]['mobile_token'];}        
        $message    = "رقم متابعه الحاله".$request->approval_number;
        $medical_request->approval_number = $request->approval_number;
        Notification::pushNotification($token,"نقابتى :فيروس كورونا",$message,$id,1);
        $medical_request->save();
        $request->session()->flash('message', $message);
        return redirect()->route('Covid19.index');
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
