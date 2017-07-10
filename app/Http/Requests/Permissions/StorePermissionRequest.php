<?php

namespace App\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth('admin')->check() && auth('admin')->user()->hasPermission('createUserPermission');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'label' => 'required',
            'code'  => 'required|alpha_dash|unique:permissions,code',
        ];
    }
}
