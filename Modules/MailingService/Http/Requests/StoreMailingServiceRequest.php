<?php

namespace Modules\MailingService\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreMailingServiceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mailing_service_name' => 'required',
            'mailing_service_amount' => 'required|numeric|min:1'
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
