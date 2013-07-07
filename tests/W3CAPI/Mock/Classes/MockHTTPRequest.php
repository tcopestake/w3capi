<?php

namespace W3CAPI\Mock\Classes;

class MockHTTPRequest extends \W3CAPI\Classes\HTTPRequest
{
    public function sendRequest($url)
    {
        $parsed_url = parse_url($url);
        
        parse_str($parsed_url['query'], $result);
        
        $url = $result['url'];

        return file_get_contents(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'ResponseData'.DIRECTORY_SEPARATOR.$url);
    }
}