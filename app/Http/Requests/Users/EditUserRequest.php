<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
    public function rules()
    {
        return [
            //

            'name' => ['required', 'string', 'max:255'],
            'street' => ['required'],
            'house_number' => ['required'],
            'city' => ['required'],
            'post_code' => ['required'],
            'country' => ['required'],
        ];
    }
}
