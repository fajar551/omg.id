<?php

namespace App\Src\Services\Upload;

use App\Src\Base\IBaseService;
use Storage;
use Illuminate\Support\Str;

class UploadService implements IBaseService {

    public function __construct() 
    {
        
    }

    public static function getInstance()
    {
        return new static();
    }

    public function formatResult($model)
    {
        return [];
    }
    
    public function createFileName($prefix = "", $file = null, $ext = '') {
        return strtolower(preg_replace('/[\W_]+/', '', $prefix) .'-' .date('Ymd-His') .'-' .Str::uuid()->toString() .'.' .($file ? $file->getClientOriginalExtension() : $ext));
    }

    public function getCleanName($filename)
    {
        return preg_replace("/[^a-zA-Z0-9-_. ]/", "", $filename);
    }
    
    public function upload(array $data, $type = 'file')
    {
        $file = @$data['file'];
        if (!empty($file)) {
            $ext = @$data['ext'] ?? '';
            $extFile = $file; 
            if ($ext) {
                $extFile = null;
            }

            $filename = $this->createFileName($data["prefix"] ?? "", $extFile, $ext);
            if ($type == 'base64') {
                Storage::put("{$data["path"]}/$filename", $file);
            } else {
                Storage::putFileAs("{$data["path"]}", $file, $filename);
            }

            if (isset($data["old_file"])) {
                Storage::delete($data["old_file"]);
            }

            return $filename;
        }

        return null;
    }

    public function delete($oldFile)
    {
        return Storage::delete($oldFile);
    }

    public function preview($path, $defaultImage = null) {
        if (Storage::exists($path)) {
            return Storage::response($path);
        }
        
        return response()->file($defaultImage ?? public_path("assets/img/image.png"));
    }

    public function handleBase64File($base64string)
    {
        $uploadpath  = 'upload/images/';
        $parts       = explode(";base64,", $base64string);
        $imageparts  = explode("image/", @$parts[0]);
        $imagetype   = $imageparts[1];
        $imagebase64 = base64_decode($parts[1]);

        return [
            'type' => $imagetype,
            'file' => $imagebase64,
        ];
    }
}