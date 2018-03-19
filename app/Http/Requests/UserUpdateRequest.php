<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class UserUpdateRequest extends ApiRequest
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
            'email' => 'required|max:50|email|unique:users,email,'.$request->get('id'),
            'first_name' => 'required',
            'last_name' => 'required',
        ];
    }

}
