<?php

namespace App\Http\Requests\Admin;

use Anacreation\MultiAuth\Model\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth("admin")->check() && auth()->user()
                                               ->can('update', Admin::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name'     => 'required',
            'email'    => 'required|unique:administrators,email,' .  $this->route()->parameter('administrator')->id,
        ];
    }
}
