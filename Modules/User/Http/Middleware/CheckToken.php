<?php

namespace Modules\User\Http\Middleware;

use App\Http\Controllers\BaseController;
use Closure;
use Modules\User\Entities\User;

class CheckToken extends BaseController
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
       if(!$user = auth()->user()){
           return $this->responseUnauthorized("Không được phép truy cập. Vui lòng đăng nhập lại!");
       }
       if ($user->user_status != User::$ACTIVATED){
           return $this->responseAccessDenied("Truy cập bị từ chối: Tài khoản đã bị khóa!");
       }
       return $next($request);
    }
}
