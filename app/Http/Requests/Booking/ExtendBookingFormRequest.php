<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class ExtendBookingFormRequest extends FormRequest
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
            'end_time' => 'required|after:start_time'
        ];
    }

    public function messages()
    {

        return [
            'end_time.required' => 'Please, fill in the end time.',
            'end_time.after' => 'The end time must be greater than start time.'
        ];

    }
}
