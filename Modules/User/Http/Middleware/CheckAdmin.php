<?php

namespace Modules\User\Http\Middleware;

use App\Http\Controllers\BaseController;
use Closure;
use Modules\User\Entities\User;

class CheckAdmin extends BaseController
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
       if ( auth()->user()->user_level == User::$IS_USER ){
           return $this->responseAccessDenied("Truy cập bị từ chối: Tính năng chỉ dành cho Quản Trị Viên!");
       }
       return $next($request);
    }
}
