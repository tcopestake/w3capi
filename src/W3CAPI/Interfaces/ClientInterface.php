<?php

namespace W3CAPI\Interfaces;

interface ClientInterface
{
    public function sendRequest($url);
    public function setParameter($parameter, $parameter_value = null);
}