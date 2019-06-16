<?php

namespace Modules\User\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_full_name" => "required",
            "user_name" => "required|email|unique:users,user_name|max:254",
            "password" => "required|min:8",
            "user_level" => "required|in:0,1"
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
