<?php

namespace App\Http\Controllers;


use Modules\Customer\Entities\Customer;

class BaseController extends Controller
{
    const STATUS_SUCCESS             = 200;
    const STATUS_BAD_REQUEST         = 400;
    const STATUS_UNAUTHORIZED        = 401;
    const STATUS_ACCESS_DENIED       = 403;
    const STATUS_SERVER_ERROR        = 500;

    protected function responseSuccess( $data = NULL,$message = ''){
        $data = (object)[
            'data'        => $data,
            'message'     => $message,
            'status_code' => static::STATUS_SUCCESS
        ];
        return response()->json( $data,static::STATUS_SUCCESS );
    }
    public function responseBadRequest($message = '' ){
        $newData = [
            'message'     => $message,
            'status_code' => static::STATUS_BAD_REQUEST
        ];
        return response()->json( $newData,static::STATUS_BAD_REQUEST );
    }
    public function responseUnauthorized($message = '' ){
        $newData = [
            'message'     => $message,
            'status_code' => static::STATUS_UNAUTHORIZED
        ];
        return response()->json( $newData,static::STATUS_UNAUTHORIZED );
    }
    public function responseAccessDenied($message = '' ){
        $newData = [
            'message'     => $message,
            'status_code' => static::STATUS_ACCESS_DENIED
        ];
        return response()->json( $newData,static::STATUS_ACCESS_DENIED );
    }
    public function responseServerError( $message){
        $data = [
            'message'     => $message,
            'status_code' => static::STATUS_SERVER_ERROR
        ];
        return response()->json( $data,static::STATUS_SERVER_ERROR );
    }

    public function getCustomerCurrent(){
        $user = auth()->user();
        $customer = Customer::where("user_id", $user->user_id)->first();
        return $customer;
    }
}
