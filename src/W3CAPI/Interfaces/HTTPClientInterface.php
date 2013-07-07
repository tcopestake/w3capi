<?php

namespace W3CAPI\Interfaces;

interface HTTPClientInterface
{
    public function getResponse();
    public function getHeader($header = null);
    public function sendRequest($url);
    public function getStatusCode();
}