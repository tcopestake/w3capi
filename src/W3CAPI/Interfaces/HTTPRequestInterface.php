<?php

namespace W3CAPI\Interfaces;

interface HTTPRequestInterface
{
    public function sendRequest($url);
}