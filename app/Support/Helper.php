<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

if (!function_exists('getBlogAvatar')) {
    /**
     * description
     *
     * @param
     * @return
     */
    function getBlogAvatar($blog, $size = 512)
    {
        return "https://api.tumblr.com/v2/blog/$blog.tumblr.com/avatar/$size";
    }
}

if (!function_exists('checkUrl')) {
    /**
     * description
     *
     * @param
     * @return
     */
    function checkUrl($url)
    {
        $client = new Client();

        try {
            $response = $client->get($url);
            return $response->getStatusCode();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getCode();
            }
        }
    }
}

if (!function_exists('countPhotos')) {
    /**
     * description
     *
     * @param
     * @return
     */
    function countPhotos($item)
    {
        switch (count($item)) {
            case 1:
                return 1;
                break;
            case 2:
                return 2;
                break;
            case 3:
                return 3;
                break;
            default:
                return 5;
                break;
        }
    }
}
