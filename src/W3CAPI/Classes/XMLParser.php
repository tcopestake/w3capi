<?php

namespace W3CAPI\Classes;

class XMLParser implements \W3CAPI\Interfaces\XMLParserInterface
{
    public function parse($xml)
    {
        $parsed = simplexml_load_string($xml);
        
        return $parsed;
    }
}