<?php

namespace Modules\User\Http\Requests;

use App\Http\Requests\BaseRequest;

class UpdateAvatarRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_avatar" => "required|image|mimes:jpeg, jpg, png"
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
