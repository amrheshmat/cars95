<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

//adds
use DB;
use Auth;
use Excel;
use Input;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ultraware\Roles\Models\Permission;
class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    //auth
        public function __construct()
        {
            $this->middleware('auth');
        }
        public function checkAuth($routeName,$request){
            $permission = Permission::whereRaw("FIND_IN_SET ('$routeName', slug)")->first();
            if (Auth::User()->usertype != 'superadmin') {
                if ($permission){
                    if (!$request->user()->hasPermission($permission->slug)){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return false;
                }
            }
            return true;
        }    
    //navbar sarch and API search
        public function Search(Request $request)
        {
            //get the parmeters in Session
                $caller         = ltrim($request->ani, '0');
                $search         = ltrim($request->search, '0');
                $searchphone    = ltrim($request->search, '0');
             //Session
                    session()->put('caller',$caller);
                    session()->put('search',$search);
            //Check if the Caller and phone in Database
                if(!empty($caller) || $caller != 0 || !empty($search) || $search != 0){
                    $findcaller       = \App\Phone::where('phone',session()->get('caller'))->first();
                    $searchInPhone    = \App\Phone::where('phone',session()->get('search'))->first();
                    if ($searchInPhone == null) {
                        $search = null;
                    }else{
                        $search =$searchInPhone->customer_id ;
                    }
                }
            //Route according to Search or Aheeva
                if (empty($caller)) {
                    if ($search==true) {
                        return redirect()->route('Customer.show', [$search]);
                    }else{
                        $model          = new \App\Customer;
                        $method         = 'create';
                        $action         = 'Customer.store';
                        $modelCreator   = $model->createOpener;
                        return view(TripleVision.'.Customer.create',compact('model','method','action','search','modelCreator'));

                    }
                }else{
                    if ($findcaller==true) {
                        return redirect()->route('Customer.show', [$findcaller->customer_id]);
                    }else{
                        $model      = new \App\Customer;
                        $method     = 'create';
                        $action     = 'Customer.store';
                        return view(TripleVision.'.Customer.create',compact('model','method','action','search'));
                    }
                }
        }

        public function Ajaxcontact(Request $request){
            $phone = \App\Phone::where('phone',$request->phone)->with('phonetable')->first();
            return Response()->json($phone);
        }

    //Search index
        
        public function Ajaxtable(Request $request)
        {
            $routeName  = strtolower($request->model.'.index');
            if($this->checkAuth($routeName,$request)){
                if($request->ajax()){
                    //get element
                        $rows       = $request->rows;
                        $model      = $request->model;
                        $search     = $request->search;
                        $orderby    = $request->orderby;
                        $ordertype  = $request->ordertype;
                        $page       = $request->page;
                        $conditions = $request->conditions;
                        $columns    = $request->columns;
                        $groupby    = $request->groupby;
                        $key        = $request->key;
                        $path       = $request->path;
                        $join       = '';
                        $joinsearch = '';
                    //back page and model name
                    if($path == ''){
                        $backto     = $request->model.'.pageid';
                    }else{
                        $backto     = $path.'.'.$request->model.'.pageid';
                    }
                    //check the Role & permission path
                        if ($request->model == 'Role') { $App= 'Ultraware\Roles\Models\Role'; }else{ $App= '\App\\'.$request->model; }
                    //Call the Model 
                        $model    = new $App;
                    //Helper Method
                        if (method_exists($model,'scopeGetDataTable')) {
                            $GetDataTable       = $model->getDataTable($orderby,$ordertype,$rows,$columns,$conditions);
                        }
                    //get DataTables
                        $datatable  = $GetDataTable;
                    //back to view 
                        $data   = view($backto,compact($datatable,'datatable',$model,'model'))->render();
                        return Response()->json($data);
                }
            }else{
                $error      = '<h3 class="text-danger"> we are sorry you don\'t have access to view this page </h3>';
                $data       = view('errors.Ajaxtable',compact('error'))->render();
                return Response()->json($data,400);
            };
        }
    //Save as Excel 
        public function AjaxExcel(Request $request)
        {
            $routeName  = strtolower($request->model.'.export');
            if($this->checkAuth($routeName,$request)){
                if($request->ajax() || 1 == 1 ){
                    //get element
                    $tablename    = $request->model;
                    if ($request->model == 'Role') { $App= 'Ultraware\Roles\Models\Role'; }else{ $App= '\App\\'.$request->model; }
                    //Call the Model 
                        $model    = new $App;
                    // return dd($request->all());
                    // $columns = array();
                    // foreach ($request->all() as $key => $value) {
                    //     if(!empty($value) && $key !='_token' && $key != 'model' && $key !='conditions' && $key != 'ordertype' && $key != 'orderby'){
                    //         $key    = preg_replace('/--/', '.', $key);
                    //         $columns[$key]= $value;
                    //     }
                    // }
                    // return dd($columns);
                            
                    if (method_exists($model,'scopeSaveExcel')) {   
                        // $GetDataTable       = $model->getDataTable($orderby,$ordertype,$rows,$columns,$conditions);                         
                        $data       = $model::SaveExcel($request->orderby,$request->ordertype,$rows = '',$request->columns,$request->conditions);
                    }else {
                        $data       = $model::all();
                    }

                    Excel::create($tablename, function($excel) use($data,$tablename) 
                    {
                        $excel->sheet($tablename, function($sheet) use($data) 
                        {
                            $sheet->fromArray($data);
                        });
                    })->export('xls');

                }
            }else{
                $error      = '<h3 class="text-danger"> we are sorry you don\'t have access to view this page </h3>';
                $data       = view('errors.Ajaxtable',compact('error'))->render();
                if($request->ajax()){
                    return Response()->json($data,403);
                }else{
                    return abort(403, 'Unauthorized action.');
                }

            };
        }
        public function AjaxExcelCustom(Request $request)
        {
            $routeName  = strtolower($request->model.'.exportCustom');
            if($this->checkAuth($routeName,$request)){
                if($request->ajax() || 1 == 1 ){
                    //get element
                    $tablename    = $request->model;
                    if ($request->model == 'Role') { $App= 'Ultraware\Roles\Models\Role'; }else{ $App= '\App\\'.$request->model; }
                    //Call the Model 
                        $model    = new $App;
                    if (method_exists($model,'scopeSaveExcelCustom')) {   
                        // $GetDataTable       = $model->getDataTable($orderby,$ordertype,$rows,$columns,$conditions);                         
                        $data       = $model::SaveExcelCustom($request->orderby,$request->ordertype,$rows = '',$request->columns,$conditions='');
                    }else {
                        $data       = $model::all();
                    }

                    Excel::create($tablename, function($excel) use($data,$tablename) 
                    {
                        $excel->sheet($tablename, function($sheet) use($data) 
                        {
                            $sheet->fromArray($data);
                        });
                    })->export('xls');

                }
            }else{
                $error      = '<h3 class="text-danger"> we are sorry you don\'t have access to view this page </h3>';
                $data       = view('errors.Ajaxtable',compact('error'))->render();
                if($request->ajax()){
                    return Response()->json($data,403);
                }else{
                    return abort(403, 'Unauthorized action.');
                }

            };
        }

        public function Ajaxrelationlist(Request $request)
        {
            $id         =   $request->id;
            $App        =   '\App\\'.$request->model;
            $method     =   $request->method;
            //return $request->method;
            $data       =   $App::find($id)->$method;
            return Response()->json($data);
        }

        public function Ajaxrow(Request $request)
        {
                $id = $request->id;
                $model        = '\App\\'.$request->model;
                return $model::find($id);
        }
        public function Ajaxdropdown(Request $request)
        {
            //Virables 
                $id         =   $request->id;
                $App        =   '\App\\'.$request->model;
                $method     =   $request->method;
                $search     =   $request->text;
            //Search in all ()
                $items  =   $App::find($id)->$method()->get();
                // return $items;
            return Response()->json($items);
        }      
        public function AjaxloadDashboard(Request $request)
        {
            if($request->ajax() || 1==1)
            {

                if (Auth::User()->isRole('admin|quality|closer')) {
                     //Deals
                    $Deals      =\App\Deal::selectRaw("
                                                    count('*') AS Total,
                                                    SUM(if(status = 'closed', 1, 0)) AS closed,
                                                    SUM(if(status = 'callback', 1, 0)) AS callback,
                                                    SUM(if(status = 'waiting', 1, 0)) AS waiting,
                                                    SUM(if(status = 'No Answer', 1, 0)) AS 'No Answer',
                                                    SUM(if(status = 'Answer Machine', 1, 0)) AS 'Answer Machine',
                                                    SUM(if(status = 'canceled', 1, 0)) AS canceled,
                                                    SUM(if(status = 'Not Interested', 1, 0)) AS 'Not_Interested',
                                                    SUM(if(status = 'Not Qualified', 1, 0)) AS 'Not_Qualified',
                                                    SUM(if(status = 'HMO', 1, 0)) AS HMO,
                                                    SUM(if(status = 'MSP', 1, 0)) AS MSP,
                                                    SUM(if(status = 'MCN', 1, 0)) AS MCN,
                                                    SUM(if(status = 'Escalated', 1, 0)) AS Escalated,
                                                    SUM(if(status = 'ENROLLED', 1, 0)) AS ENROLLED  
                                                    ")
                                                    //->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)')
                                                    ->whereRaw('MONTH(`created_at`) = MONTH(CURRENT_DATE()) and year(`created_at`) = year(CURRENT_DATE())')
                                                    ->get()->toArray();
                    $DealPerDay =\App\Deal::selectRaw("
                                                    count('*') AS Total,
                                                    SUM(if(status = 'closed', 1, 0)) AS closed,
                                                    SUM(if(status = 'callback', 1, 0)) AS callback,
                                                    SUM(if(status = 'waiting', 1, 0)) AS waiting,
                                                    SUM(if(status = 'No Answer', 1, 0)) AS 'No Answer',
                                                    SUM(if(status = 'Answer Machine', 1, 0)) AS 'Answer Machine',
                                                    SUM(if(status = 'canceled', 1, 0)) AS canceled,
                                                    SUM(if(status = 'Not Interested', 1, 0)) AS 'Not_Interested',
                                                    SUM(if(status = 'Not Qualified', 1, 0)) AS 'Not_Qualified',
                                                    SUM(if(status = 'HMO', 1, 0)) AS HMO,
                                                    SUM(if(status = 'MSP', 1, 0)) AS MSP,
                                                    SUM(if(status = 'MCN', 1, 0)) AS MCN,
                                                    SUM(if(status = 'Escalated', 1, 0)) AS Escalated,
                                                    SUM(if(status = 'ENROLLED', 1, 0)) AS ENROLLED 
                                                        ")->whereRaw('created_at >= CURDATE()')->get()->toArray();
                    $closDeals      =\App\Deal::whereRaw('MONTH(`closed_at`) = MONTH(CURRENT_DATE()) and year(`closed_at`) = year(CURRENT_DATE())')->count();
                    $closDealperDay =\App\Deal::whereRaw('closed_at >= CURDATE()')->count();
                    $data   = view('updateajax',compact('Deals','DealPerDay','closDeals','closDealperDay'))->render();
                    return Response()->json($data);
                }elseif (Auth::User()->isRole('agent')){
                    $user = Auth::User()->id;
                    //Deals
                        $Deals      =\App\Deal::selectRaw("
                                                        count('*') AS Total,
                                                        SUM(if(status = 'closed', 1, 0)) AS closed,
                                                        SUM(if(status = 'callback', 1, 0)) AS callback,
                                                        SUM(if(status = 'waiting', 1, 0)) AS waiting,
                                                        SUM(if(status = 'No Answer', 1, 0)) AS 'No Answer',
                                                        SUM(if(status = 'Answer Machine', 1, 0)) AS 'Answer Machine',
                                                        SUM(if(status = 'canceled', 1, 0)) AS canceled,
                                                        SUM(if(status = 'Not Interested', 1, 0)) AS 'Not_Interested',
                                                        SUM(if(status = 'Not Qualified', 1, 0)) AS 'Not_Qualified',
                                                        SUM(if(status = 'HMO', 1, 0)) AS HMO,
                                                        SUM(if(status = 'MSP', 1, 0)) AS MSP,
                                                        SUM(if(status = 'MCN', 1, 0)) AS MCN,
                                                        SUM(if(status = 'Escalated', 1, 0)) AS Escalated,
                                                        SUM(if(status = 'ENROLLED', 1, 0)) AS ENROLLED  
                                                        ")
                                                        ->whereRaw('MONTH(`created_at`) = MONTH(CURRENT_DATE()) and year(`created_at`) = year(CURRENT_DATE())')
                                                        //->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)')
                                                        ->where('created_by',$user)->get()->toArray();
                        $DealPerDay =\App\Deal::selectRaw("
                                                    count('*') AS Total,
                                                    SUM(if(status = 'closed', 1, 0)) AS closed,
                                                    SUM(if(status = 'callback', 1, 0)) AS callback,
                                                    SUM(if(status = 'waiting', 1, 0)) AS waiting,
                                                    SUM(if(status = 'No Answer', 1, 0)) AS 'No Answer',
                                                    SUM(if(status = 'Answer Machine', 1, 0)) AS 'Answer Machine',
                                                    SUM(if(status = 'canceled', 1, 0)) AS canceled,
                                                    SUM(if(status = 'Not Interested', 1, 0)) AS 'Not_Interested',
                                                    SUM(if(status = 'Not Qualified', 1, 0)) AS 'Not_Qualified',
                                                    SUM(if(status = 'HMO', 1, 0)) AS HMO,
                                                    SUM(if(status = 'MSP', 1, 0)) AS MSP,
                                                    SUM(if(status = 'MCN', 1, 0)) AS MCN,
                                                    SUM(if(status = 'Escalated', 1, 0)) AS Escalated,
                                                    SUM(if(status = 'ENROLLED', 1, 0)) AS ENROLLED 
                                                        ")->whereRaw('created_at >= CURDATE()')->where('created_by',$user)->get()->toArray();
                

                    $closDeals      =\App\Deal::whereRaw('MONTH(`closed_at`) = MONTH(CURRENT_DATE()) and year(`closed_at`) = year(CURRENT_DATE())')->where('created_by',$user)->count();
                    $closDealperDay =\App\Deal::whereRaw('closed_at >= CURDATE()')->where('created_by',$user)->count();
                    $data   = view('updateajax',compact('Deals','DealPerDay','closDeals','closDealperDay'))->render();
                    return Response()->json($data);
                }
            }
        }

        public function SendMail(Request $request){
            $this->validate($request, ['emailto'=>'required','subject'=>'required','message'=>'required']);
            $data   = $request->all();
            $body   = $request->message;
            $subject= $request->subject;
            $emailto= $request->emailto;
            Mail::send('emails.home', ['body' => $body], function ($message) use ($emailto,$subject) {
                $message->from('mohamed.reda@mobacode.com', 'Admin');
                $message->to($emailto)->bcc('mohamed.reda@mobacode.com')->subject($subject);
            });
            if (Mail::failures()) {
                return Response()->json('could you please check it again ',400);
            }
            return Response()->json(array('title'=>'success','message'=>'Your email has been sent successfully'),200);
        }

    
}
