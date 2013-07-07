<?php

namespace W3CAPI;

class Client implements Interfaces\ClientInterface
{
    protected $client;
    
    protected $lastRequest;
    
    protected $parameters = array(
                                    'charset' => 'utf-8',
                                    'output' => 'soap12',
                            );
    
    public function __construct(Interfaces\SoapClientInterface $client = null)
    {
        if(is_null($client)) {
            $client = new Classes\SoapClient;
        }
        
        $this->client = $client;
    }
    
    public function setParameter($parameter, $parameter_value = null)
    {
        if(!is_string($parameter) && !is_array($parameter)) {
            throw new Exceptions\SoapClientInvalidParameterType;
        }
        
        if(is_array($parameter)) {
            foreach($parameter as $key => $value) {
                $this->parameters[$key] = $value;
            }
        } else {
            $this->parameters[$parameter] = $parameter_value;
        }
        
        return $this;
    }
    
    public function sendRequest($url)
    {
        /*
         * The folks at W3C ask that we wait
         * at least 1 second between requests.
         * 
         */
        
        if($this->lastRequest && $this->lastRequest > time() - 1000) {
            sleep(1);
        }
        
        $this->lastRequest = time();
        
        // 
        
        $this->setParameter('url', $url);
        
        return $this->client->sendRequest(
            'http://validator.w3.org/check?'.http_build_query($this->parameters),
            'http://validator.w3.org/check'
        );
    }
}