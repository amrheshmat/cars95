<?php

namespace App\Http\Middleware;
use Ultraware\Roles\Models\Permission;
use Closure;
use Auth;
use DB;
class AutoLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // DB::enableQueryLog();
        // $user->model    = json_encode(DB::getQueryLog());
        // $user->model    = $request->route()->getName();
        // $user->route    = json_encode($request->fingerprint());

        $user = new \App\Log;
        $user->user_id  = $request->user()->id;
        $user->model    = url()->current();
        $user->methods  = json_encode($request->route()->methods());
        $user->route    = json_encode($request->route()->getName());
        $user->save();

        // abort(403, '<h3 class="text-danger"> we are sorry you don\'t have access to view this page </h3>');
        // return Auth::User()->first_name;
        return $next($request);
    }   

 

}
