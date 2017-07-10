<?php

namespace App\Http\Requests\Menus;

use App\Collection;
use App\Lesson;
use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return auth('admin')->check() && auth('admin')->user()->hasPermission("editMenu");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $classes = [
            Collection::class,
            Lesson::class,
        ];

        return [
            'title'     => 'required|',
            'type'      => 'required|in:' . implode(",", $classes),
            'id'        => 'required|in:' . $this->getObjectIds($this->get('type')),
            'url'       => 'required|unique:menus,url,' . $this->menu->id,
            'is_active' => 'required|boolean'
        ];
    }

    private function getObjectIds(string $type) {
        
        $class = app($type);

        return implode(",", $class->pluck('id')->toArray());
    }
}
