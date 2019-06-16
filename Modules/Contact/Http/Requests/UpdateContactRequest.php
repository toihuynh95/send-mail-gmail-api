<?php

namespace Modules\Contact\Http\Requests;

use App\Http\Requests\BaseRequest;

class UpdateContactRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "contact_name" => "",
            "contact_email"  => "email",
            "contact_gender" => "between:0,2"
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
