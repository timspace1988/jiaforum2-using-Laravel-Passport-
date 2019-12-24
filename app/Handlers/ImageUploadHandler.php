<?php

namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler{
    //only allow to upload images with following extensions
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $folder, $file_prefix){
        //build folder structure
        $folder_name = "upload/images/$folder/" . date("Ym/d", time());

        //public_path() will get public folder's physical address
        $upload_path = public_path() . '/' . $folder_name;

        //sometime, the file's name from clipping board has no extension name, we need to add png to it
        $extension = strtolower($file->getClientOriginalExtension()) ?:'png';

        //add a prefix to filename, the prefix could be related model's id
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        //if the uploaded file is not a image, will terminate the operation
        if(! in_array($extension, $this->allowed_ext)){
            return false;
        }

        //move the image to the target storage directory
        $file->move($upload_path, $filename);

        //config('app.url') is public folder address on server, public_path() is the public folder physical address on local computer, e.g. /home/vagrant/Code/jiaforum/public
        return ['path' => config('app.url') . "/$folder_name/$filename"];
    }
}
