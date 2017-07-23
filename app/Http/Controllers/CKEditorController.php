<?php

namespace App\Http\Controllers;

use App\Helpers\FileHandler;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Input;

class CKEditorController extends Controller
{
    public function upload()
    {
        $fileObject = $this->moveIfFileUploaded(Input::file("upload"));
        $funcNum = Input::get("CKEditorFuncNum");
        $url = $fileObject->link;
        $message = "image upload";
        return "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    }

    private function moveIfFileUploaded($value)
    {
        if ($value instanceof UploadedFile) {
            $fh               = new FileHandler();
            $link = str_replace(public_path(), '', $fh->move($value));
            $mediaRecord = Media::whereLink($link)->first();

            if(!$mediaRecord)
            {
                $fields['link'] = $link;
                $fields['name'] = $value->getClientOriginalName();
                $fields['type'] = $value->getClientMimeType();
                $mediaRecord = Media::create($fields);
            }else{
                $mediaRecord->touch();
            }
            return $mediaRecord;
        }
    }
}
