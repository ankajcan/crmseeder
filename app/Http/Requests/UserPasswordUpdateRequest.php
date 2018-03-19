<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class UserPasswordUpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'old_password' => 'required',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password|min:6',
        ];
    }

}
