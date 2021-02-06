<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function uploadImage($data, $key, $path, $isDeletable = false, $serverFileName = null)
    {
        $exploaded = explode(',', $data[$key]);

        $images = base64_decode($exploaded[1]);

        if (strstr($exploaded[0], 'jpeg', 'jpg')) {
            $extension = 'jpg';
        } else {
            $extension = 'png';
        }

        $fileName = time() . '.' . $extension;

        Storage::put("public/upload/$path/$fileName", $images);

        if ($isDeletable) {
            $deleteImage = str_replace("storage/upload/$path/", '', $serverFileName);
            Storage::disk('public')->delete("upload/$path/$deleteImage");
        }

        $finalPath = "storage/upload/$path/$fileName";

        return $finalPath;
    }

    public static function deleteImage($path, $serverFileName)
    {
        $deleteImage = str_replace("storage/upload/$path/", '', $serverFileName);
        Storage::disk('public')->delete("upload/$path/$deleteImage");
    }
}
