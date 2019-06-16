<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use Modules\Customer\Entities\Customer;

class BaseRequest extends FormRequest
{
    /**
     * Get only filed validation
     * And support add user_id to data request
     *
     * @param bool $hasUserID
     * @return array
     */
    public function dataOnly($hasCustomerID = FALSE)
    {
        $data = $this->only(array_keys($this->rules()));
        foreach ($data as $key => $value) {
            if ($data[ $key ] === "" || is_null($data[ $key ])) {
                unset($data[ $key ]);
            }
        }
        if ($hasCustomerID) {
            $user = auth()->user();
            $customer = Customer::where("user_id", $user->user_id)->first();
            $data['customer_id'] = $customer->customer_id;
        }
        return $data;
    }
}
