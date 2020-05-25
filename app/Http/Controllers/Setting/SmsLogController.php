<?php

namespace App\Http\Controllers\Setting;

use App\SmsLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsLogController extends Controller
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
        //
        $model      = new SmsLog;
        $datatable  = $model::getDataTable('sms_logs.id','desc','10');
        $tableDesign= $model->dataTable;
        return view(Setting.'.SmsLog.index',compact('model','datatable','tableDesign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return redirect()->route('SmsLog.index');

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
        return redirect()->route('SmsLog.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SmsLog  $smsLog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        if($request->ajax()){
            $model      = new \App\SmsLog;
            $model      = $model::find($id);
            $method     = 'edit';
            $action     = 'SmsLog.update';
            $modelShower= $model->editAdmin;
            $sms_result = \App\Sms::pluck('description','sms_result')->toArray();
            return view(Setting.'.SmsLog.show',compact('showData','model','method','action','modelShower','sms_result'));
        }else{
            return redirect()->route('SmsLog.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SmsLog  $smsLog
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsLog $smsLog)
    {
        //
        return redirect()->route('SmsLog.index');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SmsLog  $smsLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsLog $smsLog)
    {
        //
        return redirect()->route('SmsLog.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SmsLog  $smsLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsLog $smsLog)
    {
        //
        return redirect()->route('SmsLog.index');

    }
}
