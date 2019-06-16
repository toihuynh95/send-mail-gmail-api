<?php

namespace Modules\Campaign\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreCampaignRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required|exists:projects,project_id',
            'contact_group_id' => 'required|exists:contact_groups,contact_group_id',
            'campaign_name' => 'required',
            'campaign_email_id' => 'required',
            'campaign_email_name' => 'required|email',
            'campaign_title' => 'required',
            'campaign_content' => 'required',
            'campaign_attach_file' => '',
            'campaign_schedule' => 'required|date_format:Y-m-d H:i:s'
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
