<?php

namespace App\Http\Requests\Tests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth('admin')->check() && auth("admin")->user()->hasPermission('createTest');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title' => "required"
        ];
    }
}
