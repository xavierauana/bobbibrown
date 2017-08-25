<?php

namespace App\Http\Requests\Collections;

use App\Permission;
use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth('admin')->check() && auth('admin')->user()->hasPermission("createCollection");

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title'         => "required",
            'is_featured'   => "boolean",
            'is_new'        => "boolean",
            'permission_id' => "required|in:" . implode(",", Permission::pluck('id')->toArray()),
        ];
    }
}
