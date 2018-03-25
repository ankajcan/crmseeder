<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Symfony\Component\HttpFoundation\Request;

class ContactStoreRequest extends ApiRequest
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
            'first_name' => 'required_if:type,'.Contact::TYPE_PERSON,
            'name' => 'required_if:type,'.Contact::TYPE_ORGANISATION,
        ];
    }

    public function messages()
    {
        return [
            'first_name.required_if' => 'First name is required',
            'name.required_if' => 'Name is required',
        ];
    }

}
