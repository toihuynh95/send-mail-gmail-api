<?php

namespace Modules\ContactGroup\Http\Requests;

use App\Http\Requests\BaseRequest;

class UpdateContactGroupRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "contact_group_name" => "",
            "contact_group_status" => "between:0,1"
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
