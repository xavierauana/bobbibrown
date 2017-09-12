<?php

namespace App\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth('admin')->check() && auth('admin')->user()->hasPermission('editUserPermission');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'label' => 'required',
            'code'  => [
                "alpha_dash",
                Rule::unique('permissions')->ignore($this->route('permission')->id),
            ]
        ];
    }
}
