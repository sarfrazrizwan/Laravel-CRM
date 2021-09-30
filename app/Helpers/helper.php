<?php

use Faker\Provider\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

if (!function_exists('store_file')) {
    function store_file($image, $destinationPath, $imageName = null)
    {
        if (empty($imageName)) {
            $imageName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
        }


        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, '755', true);
        }

        $image->move($destinationPath, $imageName);
        return $imageName;
    }
}
if (!function_exists('store_base64')) {
    function store_base64($file, $destinationPath, $name = null)
    {
        $extension = explode('/', mime_content_type($file))[1];
        if (empty($name)) {
            $name = time() . uniqid() . ".$extension";
        }


        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, '755', true);
        }

        $base64_str = substr($file, strpos($file, ",") + 1);

        //decode base64 string
        $file = base64_decode($base64_str);
//        Storage::disk('local')->put($imageName, $image);

        File::put($destinationPath . '/' . $name, $file);
        return $name;
    }
}

if (!function_exists('ext_base64')) {
    function ext_base64($base64)
    {
        return explode('/', mime_content_type($base64))[1];
    }
}

if (!function_exists('base64_type')) {
    function base64_type($base64)
    {
        $extension = explode('/', mime_content_type($base64))[1];
        $type = 'Document';
        if (in_array($extension, ['jpg', 'png', 'jpeg'])){
            $type = 'Image';
        }
        return $type;
    }
}


if (! function_exists('array_only')) {
    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     *
     * @deprecated Arr::only() should be used directly instead. Will be removed in Laravel 5.9.
     */
    function array_only($array, $keys)
    {
        return \Illuminate\Support\Arr::only($array, $keys);
    }
}

if (! function_exists('is_base64_image')){
    function is_base64_image($value)
    {
        $base64_str = substr($value, strpos($value, ",")+1);
        $image = base64_decode($base64_str);

        $f = finfo_open();
        $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
        $formats = ['image/png', 'image/jpeg', 'image/jpg'];

        return in_array($result, $formats);
    }
}

if (! function_exists('v_echo')){
    function v_echo($msg)
    {
        echo $msg.PHP_EOL;
    }
}

if (! function_exists('json_response')){
    function json_response($message = null, $status = 200)
    {
        return response()->json(['message' => $message], $status);
    }
}