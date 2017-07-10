<?php

namespace App\Http\Requests\Lessons;

use App\Permission;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth('admin')->check() && auth('admin')->user()->hasPermission("editLesson");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title'         => "required",
            'body'          => "required",
            'is_standalone' => "required|boolean",
            'permission_id' => "required|in:" . implode(",", Permission::pluck('id')->toArray()),
        ];
    }
}
