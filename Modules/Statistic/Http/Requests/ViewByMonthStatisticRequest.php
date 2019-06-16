<?php

namespace Modules\Statistic\Http\Requests;

use App\Http\Requests\BaseRequest;

class ViewByMonthStatisticRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'statistic_year' => 'required|date_format:Y',
            'statistic_month' => 'required|date_format:m',
            'project_id' => 'required|exists:projects,project_id'
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
