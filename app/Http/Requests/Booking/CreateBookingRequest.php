<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
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
            'date' => 'required|after:yesterday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time'
        ];
    }

    public function messages()
    {

        return [
            'date.required' => 'Please, fill in the date.',
            'date.after' => 'You cant select a date in the past!',
            'start_time.required' => 'Please, fill in the start time.',
            'end_time.required' => 'Please, fill in the end time.',
            'end_time.after' => 'The end time must be greater than start time.'
        ];

    }
}
