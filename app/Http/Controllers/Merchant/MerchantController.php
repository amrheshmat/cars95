<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listRequests(Request $request)
    {
        $merchant = $request->user();
        $model      = new \App\MedicalRequest;
        $tableDesign= $model->dataTable;
        $requests  = \App\MedicalRequest::where('provider_id',$merchant->provider_id)->get();
        return view('Merchant.Medical.MedicalRequest.index',compact('model','requests','tableDesign'));
 
    }
}
