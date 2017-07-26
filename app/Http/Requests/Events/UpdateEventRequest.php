<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth('admin')->check() && auth('admin')->user()->hasPermission('updateEvent');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title'          => "required",
            'body'           => "required",
            'photo'          => "image",
            'venue'          => "required",
            'vacancies'      => "required|integer|min:1",
            'start_datetime' => "required",
            'end_datetime'   => "required",
        ];
    }
}
