<?php
namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\IpUtils;
use Auth;
use DB;
class IPAddresses
{
    /**
     * List of valid IPs.
     *
     * @var array
     */
    protected $ips = ['42.60.187.198','188.102.29.159','127.0.0.1'];

    /**
     * List of valid IP-ranges.
     *
     * @var array
     */
    protected $ipRanges= ['12.64.103.24',];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::User()->usertype == 'user' ) {
        // if (Auth::User()->usertype != 'user') {
            foreach ($request->getClientIps() as $ip) {
                if (! $this->isValidIpUser($ip) && ! $this->isValidIpCallcenter($ip)) {
                    abort(403, '<h3 class="text-danger"> we are sorry your IP '.$ip.' dosn\'t have access right now back again later or call your Admin </h3>');

                }
            }
        }
        return $next($request);
    }


    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    /**
     * Check if the given IP is valid.
     *
     * @param $ip
     * @return bool
     */
    protected function isValidIpUser($ip)
    {
        return in_array($ip, Auth::User()->Ip_belongsToMany()->pluck('ip')->toArray());
    }

    /**
     * Check if the ip is in the given IP-range.
     *
     * @param $ip
     * @return bool
     */
    protected function isValidIpCallcenter($ip)
    {        
        // $Callcenters= Auth::User()->getCallcenterIP();
        // $checkip = \App\IP::join('iprelations', function ($join) use($Callcenters) {$join->on('ips.id', '=', 'iprelations.ip_id')->where('iprelation_type' ,'=' ,'App\\Callcenter')->whereIn('iprelation_id', $Callcenters);})->pluck('ip')->toArray();
        // return in_array($ip, $checkip);
        return '';
    }
}
