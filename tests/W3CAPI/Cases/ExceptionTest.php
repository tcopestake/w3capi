<?php

namespace W3CAPI\Cases;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    protected $soap;
    protected $client;
    
    protected function setUp()
    {
        $this->soap     = new \W3CAPI\Classes\SoapClient;

        $this->client   = new \W3CAPI\Client;
    }

    protected function tearDown()
    {
        
    }

    public function testBadOptionException1()
    {
        $this->setExpectedException('\W3CAPI\Exceptions\SoapClientInvalidOptionType');
        $this->soap->setOption(false);
    }
    
    public function testBadOptionException2()
    {
        $this->setExpectedException('\W3CAPI\Exceptions\SoapClientInvalidOptionType');
        $this->soap->setOption(new \stdClass);
    }
    
    public function testBadParameterException1()
    {
        $this->setExpectedException('\W3CAPI\Exceptions\SoapClientInvalidParameterType');
        $this->soap->setParameter(false);
    }
    
    public function testBadParameterException2()
    {
        $this->setExpectedException('\W3CAPI\Exceptions\SoapClientInvalidParameterType');
        $this->soap->setParameter(new \stdClass);
    }
    
    public function testBadParameterException3()
    {
        $this->setExpectedException('\W3CAPI\Exceptions\SoapClientInvalidParameterType');
        $this->client->setParameter(false);
    }
    
    public function testBadParameterException4()
    {
        $this->setExpectedException('\W3CAPI\Exceptions\SoapClientInvalidParameterType');
        $this->client->setParameter(new \stdClass);
    }
    
    public function testUnknownErrorException()
    {
        $this->validator = new \W3CAPI\Validator(new \W3CAPI\Mock\Classes\MockW3CClient);
        
        $this->setExpectedException('\W3CAPI\Exceptions\ValidatorUnknownError');
        $this->validator->validate("doesn't matter");
    }
    
}