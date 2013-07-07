<?php

namespace W3CAPI\Interfaces;

interface SoapClientInterface
{
    public function setOption($option, $option_value = null);
    public function setParameter($parameter, $parameter_value = null);
    public function sendRequest($url, $namespace);
}