<?php

namespace App\Http\Requests\Lessons;

use App\Permission;
use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth('admin')->check() && auth('admin')->user()->hasPermission('createLesson');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title'         => "required",
            'content'       => "required",
            'is_standalone' => "required|boolean",
            'permission'    => "required|in:" . implode(",", Permission::pluck('id')->toArray()),
        ];
    }
}