<?php
/**
 * Author: Xavier Au
 * Date: 23/7/2017
 * Time: 4:48 PM
 */

namespace App\Helpers;


use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHandler
{
    protected $path;

    function __construct($path=null)
    {
        $path ? $this->path = $path : $this->path = public_path().'/files';
        if(!File::exists($this->path)) File::makeDirectory($this->path);
    }

    public function move(UploadedFile $file, $filename=null, $directory=null)
    {
        if(!$filename) $filename = $file->getClientOriginalName();
        if(!$directory) $directory = $this->path;
        $file->move($directory,$filename);
        return $directory.'/'.$filename;
    }
}