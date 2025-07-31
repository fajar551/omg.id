<?php

namespace App\Src\Services\EditorJS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MetaFetcher
{
    /**
     * get meta data from any url.
     *
     * @param string $url
     * @return \Illuminate\Http\JsonResponse
     */
    public static function fetch(string $url)
    {
        $client = new Client([
            'timeout'  => 30.0,
        ]);

        try{
            $response = $client->request('GET', $url);
        }catch(RequestException $e){
            return response()->json([
                'message' => 'Could not load URL content',
            ], 422);
        }
        
        $html = (string)$response->getBody();

        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');
        $metas = $doc->getElementsByTagName('meta');
        
        $title = $nodes->item(0)->nodeValue;
        $description = '';
        $imageUrl = '';

        for($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if($meta->getAttribute('name') == 'description')
                $description = $meta->getAttribute('content');
            if($meta->getAttribute('property') == 'og:image')
                $imageUrl = $meta->getAttribute('content');
        }

        /*
        if($imageUrl && ($callbackStoreImage = config('laravel-editor-js.fetch_url_store_image_callback'))){
            $imageUrl = call_user_func_array($callbackStoreImage, [
                $imageUrl,
            ]);
        }
        */

        return response()->json([
            'success' => 1,
            'meta' => [
                'title' => $title,
                'description' => $description,
                'image' => [
                    'url' => $imageUrl,
                ],
            ],
        ]);
    }

    /**
     * @deprecated use fetch instead
     * get meta data from any url.
     *
     * @param string $url
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMeta(string $url)
    {
        $url = $url;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    
        $data = curl_exec($ch);
        curl_close($ch);

        // Load HTML to DOM object
        $doc = new \DOMDocument();
        @$doc->loadHTML($data);
        
        // Parse DOM to get Title data
        $nodes = $doc->getElementsByTagName('title');
        $title = $nodes->item(0)->nodeValue;
        
        // Parse DOM to get metadata
        $metas = $doc->getElementsByTagName('meta');
        $description = $keywords = '';
        for ($i = 0; $i < $metas->length; $i++) {
            $meta = $metas->item($i);

            if ($meta->getAttribute('name') == 'description') {
                $description = $meta->getAttribute('content');
            }

            if ($meta->getAttribute('name') == 'keywords') {
                $keywords = $meta->getAttribute('content');
            }
        }

        return response()->json([
            'success' => 1,
            'meta' => [
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords,
            ]
        ]);
    }
}