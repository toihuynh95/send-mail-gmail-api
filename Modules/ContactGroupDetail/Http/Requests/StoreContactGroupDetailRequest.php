<?php

namespace Modules\ContactGroupDetail\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreContactGroupDetailRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "contact_group_id" => "required|exists:contact_groups,contact_group_id",
            "contact_id" => "required|exists:contacts,contact_id",
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
