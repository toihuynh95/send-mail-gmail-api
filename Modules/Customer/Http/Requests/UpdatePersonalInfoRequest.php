<?php

namespace Modules\Customer\Http\Requests;

use App\Http\Requests\BaseRequest;

class UpdatePersonalInfoRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "customer_gender" => "between:0,2",
            "customer_phone" => "unique:customers,customer_phone,".$this->customer_id.",customer_id",
            "customer_address" => ""
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
