<?php
     
    namespace App\Http\Middleware;
     
    use Ultraware\Roles\Models\Permission;
    use Closure;
    use Auth;
    class AutoCheckPermission
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
            $routeName = $request->route()->getName();
            $permission = Permission::whereRaw("FIND_IN_SET ('$routeName', slug)")->first();
            if (Auth::User()->usertype != 'superadmin') {
                if ($permission)
                {
                    if (!$request->user()->hasPermission($permission->slug))
                    {
                        if($request->ajax()){
                            return Response()->json('<center><h3 class="text-danger"> we are sorry you don\'t have access to view or submit this page </h3></center>');
                        }
                        abort(403, '<h3 class="text-danger"> we are sorry you don\'t have access to view this page </h3>');
                    }
                }
            }
            return $next($request);
        }
    }
            

