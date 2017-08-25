<?php

namespace App\Http\Requests\Lines;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth("admin")->check() and auth('admin')->user()->hasPermission("updateLine");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'category_id' => 'required|in:' . implode(",", Category::pluck('id')->toArray())
        ];
    }
}
