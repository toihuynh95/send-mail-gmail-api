<?php

namespace Modules\Contact\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreContactRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "contact_name" => "required",
            "contact_email"  => "required|email",
            "contact_gender" => "required|between:0,2",
            "contact_group_id" => "",
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
