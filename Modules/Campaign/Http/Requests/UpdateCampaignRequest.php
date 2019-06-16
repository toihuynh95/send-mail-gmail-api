<?php

namespace Modules\Campaign\Http\Requests;

use App\Http\Requests\BaseRequest;

class UpdateCampaignRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'campaign_name' => '',
            'campaign_title' => '',
            'campaign_content' => '',
            'campaign_schedule' => 'date_format:Y-m-d H:i:s',
            'campaign_status' => '',
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
