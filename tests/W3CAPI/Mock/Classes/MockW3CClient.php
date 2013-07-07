<?php

namespace W3CAPI\Mock\Classes;

class MockW3CClient implements \W3CAPI\Interfaces\ClientInterface
{
    public function sendRequest($url)
    {
        return false;
    }
    
    public function setParameter($parameter, $parameter_value = null)
    {
        
    }
}