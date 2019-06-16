<?php

namespace Modules\Project\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreProjectRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,customer_id',
            'project_type_id' => 'required|exists:project_types,project_type_id',
            'mailing_service_id' => 'required|exists:mailing_services,mailing_service_id',
            'contract_code' => 'required',
            'project_name' => 'required'
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
