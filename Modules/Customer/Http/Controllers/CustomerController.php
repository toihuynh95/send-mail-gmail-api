<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Http\Requests\UpdatePersonalInfoRequest;
use Modules\User\Entities\User;

class CustomerController extends BaseController
{
    public function show(){
        $customer_data = Customer::orderBy('customer_id', 'desc')->get();
        foreach ($customer_data as $key => $value){
            $customer_data[$key]['customer_created_at'] = date('d-m-Y H:i:s', strtotime($customer_data[$key]['customer_created_at']));
        }
        return datatables()->of($customer_data)->toJson();
    }

    public function showAll(){
        $customer_data = Customer::orderBy('customer_id', 'desc')->get();
        foreach ($customer_data as $key => $value){
            $user = User::where('user_id', $value->user_id)->where('user_status', User::$ACTIVATED)->first();
            if(is_null($user)){
                $customer_data[$key]['customer_status'] = User::$DEACTIVATED;
            }
            else{
                $customer_data[$key]['customer_status'] = User::$ACTIVATED;
            }
            $customer_data[$key]['customer_name'] = $customer_data[$key]['customer_name'] . ' - ' . $customer_data[$key]['customer_email'];
        }
        return $this->responseSuccess($customer_data, "Danh sách tất cả khách hàng");
    }

    public function updatePersonalInfo(UpdatePersonalInfoRequest $request){
        $customer_data = $request->dataOnly(true);
        $customer = Customer::find($customer_data["customer_id"]);
        if(is_null($customer)){
            return $this->responseBadRequest("Thông tin của khách hàng không tồn tại!");
        }
        $customer->update($customer_data);
        return $this->responseSuccess($customer, "Cập nhật thông tin thành công!");
    }

    public function showPersonalInfo(){
        $customer = $this->getCustomerCurrent();
        if(is_null($customer)){
            return $this->responseBadRequest("Thông tin của khách hàng không tồn tại!");
        }
        return $this->responseSuccess($customer, "Thông tin chi tiết của khách hàng.");
    }
}
