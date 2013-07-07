<?php

namespace W3CAPI\Classes;

class HTTPRequest implements \W3CAPI\Interfaces\HTTPRequestInterface
{
    public function sendRequest($url)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'W3C validator wrapper');

        $response = curl_exec($curl);

        return $response;
    }
}