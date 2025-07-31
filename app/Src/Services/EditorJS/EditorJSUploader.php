<?php

namespace App\Src\Services\EditorJS;

use App\Src\Services\Upload\UploadService;

class EditorJSUploader
{
     /**
     * Handle upload image by file for editor.js.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function upload(array $data)
    {
        \Validator::make($data, [
            'image' => 'image|mimes:jpg,jpeg,png|max:2000',
        ])->validate();

        $fileName = '';
        if($file = @$data['image']) {
            $fileName = UploadService::getInstance()->createFileName('content', $file);
            $file->move(public_path("uploads/temp"), $fileName);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Upload success!',
            'file' => [
                'url' => url("uploads/temp/$fileName"),
                'fileName' => $fileName,
            ],
        ]);
    }

    /**
     * Handle upload image by url for editor.js.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function fetchImage(array $data)
    {
        $fileContents = @file_get_contents($data['url']);
        $imageUrl = $data['url'];

        // TODO: If you wish to handle the file by url or if you wish to save fetched image to upload storage
        // if($fileContents){
        //     $imageSize = getimagesizefromstring($fileContents);
        //     $imageUrl = call_user_func_array($callbackUploadImage, [
        //         $fileContents,
        //         Tools::mime2ext($imageSize['mime']),
        //         $imageSize['mime'],
        //         $imageSize[0],
        //         $imageSize[1],
        //     ]);
        // }

        return  response()->json([
            'success' => 1,
            'message' => 'Upload success!',
            'file' => [
                'url' => $imageUrl,
            ],
        ]);
    }
}