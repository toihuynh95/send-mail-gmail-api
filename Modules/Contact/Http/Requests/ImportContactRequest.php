<?php

namespace Modules\Contact\Http\Requests;

use App\Http\Requests\BaseRequest;

class ImportContactRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "contact_file" => "required|mimes:xlsx",
            "contact_group_id" => "exists:contact_groups,contact_group_id"
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
