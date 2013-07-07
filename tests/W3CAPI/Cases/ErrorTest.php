<?php

namespace W3CAPI\Cases;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
    protected $validator;
    
    protected function setUp()
    {
        $http_request       = new \W3CAPI\Mock\Classes\MockHTTPRequest;
        
        $http_client        = new \W3CAPI\Classes\HTTPClient($http_request);
        
        $soap_client        = new \W3CAPI\Classes\SoapClient($http_client);

        $client             = new \W3CAPI\Client($soap_client);
        
        $this->validator    = new \W3CAPI\Validator($client);
    }

    protected function tearDown()
    {
        
    }
    
    public function testValidityFlag()
    {
        try {
            $this->validator->validate("error.http-response");
        }
        catch(\Exception $e) {
            
        }
        
        $this->assertFalse($this->validator->isValid());
    }
    
    public function testBadResponseException()
    {
        $this->setExpectedException('\W3CAPI\Exceptions\SoapClientBadResponse');
        $this->validator->validate("error.http-response");
    }
}