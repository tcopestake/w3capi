<?php

namespace W3CAPI\Cases;

class InvalidityTest extends \PHPUnit_Framework_TestCase
{
    protected $validator;
    
    protected function setUp()
    {
        $http_request       = new \W3CAPI\Mock\Classes\MockHTTPRequest;
        
        $http_client        = new \W3CAPI\Classes\HTTPClient($http_request);
        
        $soap_client        = new \W3CAPI\Classes\SoapClient($http_client);

        $client             = new \W3CAPI\Client($soap_client);
        
        $this->validator    = new \W3CAPI\Validator($client);
        
        $this->validator->validate("invalid.http-response");
    }

    protected function tearDown()
    {
        
    }
    
    public function testValidityFlag()
    {
        $this->assertFalse($this->validator->isValid());
    }
    
    public function testErrorCount()
    {
        $this->assertGreaterThan(0, $this->validator->getErrorCount());
    }
}