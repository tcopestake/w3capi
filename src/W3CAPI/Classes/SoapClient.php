<?php

namespace W3CAPI\Classes;

class SoapClient implements \W3CAPI\Interfaces\SoapClientInterface
{
    protected $options = array();
    protected $parameters = array();

    protected $http;
    protected $parser;

    public function __construct(
        \W3CAPI\Interfaces\HTTPClientInterface $client = null,
        \W3CAPI\Interfaces\XMLParserInterface $parser = null
    ) {
        if(is_null($client)) {
            $client = new HTTPClient;
        }
        
        if(is_null($parser)) {
            $parser = new XMLParser;
        }
        
        $this->http = $client;
        $this->parser = $parser;
    }
    
    public function setOption($option, $option_value = null)
    {
        if(!is_string($option) && !is_array($option)) {
            throw new \W3CAPI\Exceptions\SoapClientInvalidOptionType;
        }
        
        if(is_array($option)) {
            foreach($option as $key => $value) {
                $this->options[$key] = $value;
            }
        } else {
            $this->options[$option] = $option_value;
        }
        
        return $this;
    }
    
    public function setParameter($parameter, $parameter_value = null)
    {
        if(!is_string($parameter) && !is_array($parameter)) {
            throw new \W3CAPI\Exceptions\SoapClientInvalidParameterType;
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
    
    public function sendRequest($url, $namespace)
    {
        $xml = $this->http->sendRequest($url)->getResponse();

        $xml_nodes = $this->parser->parse($xml);
        
        $namespaces = $xml_nodes->getDocNamespaces(true);
        
        $body_nodes = $xml_nodes->children($namespaces['env'])->Body->children($namespaces['m']);
        
        if(!isset($body_nodes->markupvalidationresponse)) {
            throw new \W3CAPI\Exceptions\SoapClientBadResponse;
        }
        
        $structure = $this->parseSoapResponseRecursive($body_nodes->markupvalidationresponse);
        
        $structure = $structure['markupvalidationresponse'];

        return $structure;
    }
    
    /* */
    
    protected function parseSoapResponseRecursive($node)
    {
        $child_nodes = array();
        
        $name_counter = 1;
        
        foreach($node as $name => $value) {
            if($value->count() > 0) {
                if(isset($child_nodes[$name])) {
                    $name .= "_{$name_counter}";
                    
                    ++$name_counter;
                }

                $child_nodes[$name] = $this->parseSoapResponseRecursive($value);
            } else {
                $child_nodes[$name] = (string)$value;
            }
        }
        
        // Flatten single-element arrays

        return $child_nodes;
    }
}