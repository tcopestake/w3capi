<?php

namespace W3CAPI\Classes;

class HTTPClient implements \W3CAPI\Interfaces\HTTPClientInterface
{
    protected $headers = array();
    protected $response;
    protected $statusCode;
    
    protected $request;
    
    public function __construct(\W3CAPI\Interfaces\HTTPRequestInterface $request = null)
    {
        if(is_null($request)) {
            $request = new HTTPRequest;
        }
        
        $this->request = $request;
    }

    public function sendRequest($url)
    {
        $response = $this->request->sendRequest($url);

        // Process header
        
        $header_ending = strpos($response, "\r\n\r\n");
        
        $header = substr($response, 0, $header_ending);

        $headers = explode("\r\n", $header);
        
        foreach($headers as $header) {
            $header = explode(': ', $header, 2);
            
            if(isset($header[1])) {            
                $this->headers[$header[0]] = trim($header[1]);
            } else {
                if(substr($header[0], 0, 4) === 'HTTP') {
                    $code = substr($header[0], strpos($header[0], ' ') + 1, 3);
                    
                    $this->statusCode = (int)trim($code);
                }
            }
        }
        
        // Process body
        
        $this->response = substr($response, $header_ending + 4);
        
        // 
        
        return $this;
    }
    
    public function getResponse()
    {
        return $this->response;
    }
    
    public function getHeader($header = null)
    {
        if(is_null($header)) {
            return $this->headers;
        } else {
            return (isset($this->headers[$header]))
                    ? $this->headers[$header]
                    : null;
        }
    }
    
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}