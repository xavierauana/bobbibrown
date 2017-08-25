<?php

namespace App\Http\Requests\Products;

use App\Line;
use App\Permission;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check() and auth('admin')->user()->hasPermission('updateProduct');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'line_id.*'     => "required|in:" . implode(",", Line::pluck('id')->toArray()),
            'permission_id' => "required|in:" . implode(",", Permission::pluck('id')->toArray()),
            'name'          => 'required',
            'keywords'      => 'required',
            'content'       => 'required',
        ];
    }
}
