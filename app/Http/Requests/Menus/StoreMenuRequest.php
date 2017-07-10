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
        return auth('admin')->check() && auth('admin')->user()->hasPermission("storeMenu");
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

        $this->updateRequest();

        return [
            'title'     => 'required|',
            'type'      => 'required|in:' . implode(",", $classes),
            'id'        => 'required|in:' . $this->getObjectIds($this->get('type')),
            'url'       => 'required|unique:menus,url',
            'is_active' => 'required|boolean'
        ];
    }

    private function getObjectIds(string $type) {

        $class = app($type);

        return implode(",", $class->pluck('id')->toArray());
    }

    private function updateRequest() {
        $type_id = explode("_", $this->get('collection_lesson'));
        foreach ($type_id as $index => $item) {
            if ($index == 0) {
                $this->merge(['type' => $item]);
            }
            if ($index == 1) {
                $this->merge(['id' => $item]);
            }
        }
    }
}
