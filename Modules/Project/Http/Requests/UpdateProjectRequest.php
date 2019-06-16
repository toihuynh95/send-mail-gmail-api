<?php

namespace Modules\Project\Http\Requests;

use App\Http\Requests\BaseRequest;

class UpdateProjectRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_type_id' => 'exists:project_types,project_type_id',
            'mailing_service_id' => 'exists:mailing_services,mailing_service_id',
            'project_status' => 'between:0,1',
            'project_name' => ''
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
