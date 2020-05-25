<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class DashboradController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $from   = Carbon::now()->startOfMonth();
        $to     = Carbon::now()->endOfMonth();
        $user   = \App\User::findOrFail(Auth::User()->id);

        if ($user->hasRole('superadmin')) 
        { 
            $News    = \App\News::count();
            $users   = \App\User::count();
            $clients = \App\OrganizationMember::count();
        }

        if ($user->hasRole('superadmin|medical|syndicate.admin')) 
        { 
            $pending_medical    = \App\MedicalRequest::where('status',0)->count();
            $accepted_medical   = \App\MedicalRequest::where('status',1)->count();
            $refused_medical    = \App\MedicalRequest::where('status',2)->count();
            $medicalProviders_counts    = DB::table('medical_requests')->whereMonth('created_at', '=', Carbon::now()->month)->select('name', DB::raw('count(*) as requests'))->groupBy('name')->orderBy('requests','DESC')->get()->take(5);  
            $medicalActions_users       = DB::table('medical_requests')->select('users.name','users.picture', DB::raw('count(*) as requests', 'users.name'))->LeftJoin('users','users.id','medical_requests.updated_by')->groupBy('updated_by')->orderBy('requests','DESC')->get()->take(4);                     
            $late_medical_requests = \App\MedicalRequest::whereMonth('created_at', '=', Carbon::now()->month)->where('status',0)->where('created_at', '<', Carbon::now()->subHours(5))->orderBy('created_at','DESC')->get()->take(5);
            $medical_requests_latest = array();
            foreach ($late_medical_requests as  $index=>$mrequest) {
                $medical_requests_latest[$index]['id'] = $mrequest->request_id;                
                $medical_requests_latest[$index]['name'] = $mrequest->name;                
                $date = Carbon::parse($mrequest->created_at);
                $now  = Carbon::now();                
                $hours = $date->diffInHours($now);
                $medical_requests_latest[$index]['hours'] = $hours;
            }

            $total_medical = $pending_medical+$accepted_medical+$refused_medical;
            $medical = array("pending"  => $pending_medical,"pending_percentage"  => ( $pending_medical/$total_medical)*100,"accepted" => $accepted_medical,"accepted_percentage"  => ( $accepted_medical/$total_medical)*100,"refused"  => $refused_medical,"refused_percentage"  => ( $refused_medical/$total_medical)*100,);
        }
        
        if ($user->hasRole('superadmin|trip')) 
        { 
            $Trip    = \App\Trip::count();
        }

        if ($user->hasRole('superadmin|financial')) 
        { 
             $monthly_amount = \App\Transaction::whereMonth(
                'created_at', '=', Carbon::now()->month
            )->sum('amount');
            $yearly_amount = \App\Transaction::whereYear(
                'created_at', '=', Carbon::now()->year
            )->sum('amount');
    
            $amount_charts = \App\Transaction::whereYear(
                'created_at', '=', Carbon::now()->year
            )->orderBy('created_at','DESC')->get(['amount','created_at'])->take(15);
        }

        if ($user->hasRole('superadmin|erecords')) 
        { 
            $pending_eRecords    = \App\EngineeringRecordRequest::where('status',0)->count();
            $accepted_eRecords   = \App\EngineeringRecordRequest::where('status',1)->count();
            $refused_eRecords    = \App\EngineeringRecordRequest::where('status',2)->count();
            $eRecords = array(
                "pending"  => $pending_eRecords,
                "accepted" => $accepted_eRecords,
                "refused"  => $refused_eRecords,
            );
        }   

           


            
        
        return view('Dashboard.admin',compact('medicalActions_users','medical_requests_latest','medicalProviders_counts','MedicalRequest','Trip','News','monthly_amount','yearly_amount','amount_charts','eRecords','medical'));
        // return view('Dashboard');
    }
}
