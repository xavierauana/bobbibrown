<?php
/**
 * Author: Xavier Au
 * Date: 15/8/2017
 * Time: 1:49 PM
 */

namespace App\Services;


use App\Helpers\FileHandler;
use App\Media;
use Illuminate\Http\Request;

class SaveFormMedia
{
    public static function save(Request $request, string $field): ?Media {
        if ($request->hasFile($field)) {
            $value = $request->file($field);
            $fh = new FileHandler();
            $link = str_replace(public_path(), '', $fh->move($value));
            $mediaRecord = Media::whereLink($link)->first();

            if (!$mediaRecord) {
                $fields['link'] = $link;
                $fields['name'] = $value->getClientOriginalName();
                $fields['type'] = $value->getClientMimeType();
                $mediaRecord = Media::create($fields);
            } else {
                $mediaRecord->touch();
            }

            return $mediaRecord;
        }

        return null;
    }

}