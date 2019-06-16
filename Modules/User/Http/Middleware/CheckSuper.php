<?php

namespace Modules\User\Http\Middleware;

use App\Http\Controllers\BaseController;
use Closure;
use Modules\User\Entities\User;

class CheckSuper extends BaseController
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
       if (auth()->user()->user_level != User::$IS_SUPER){
           return $this->responseAccessDenied("Truy cập bị từ chối: Tính năng chỉ dành cho Quản Trị Viên Cấp Cao!");
       }
       return $next($request);
    }
}
