<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Request;

class UserStoreRequest extends ApiRequest
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
            'email' => 'required|max:50|email|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password|min:6',
        ];
    }

}
