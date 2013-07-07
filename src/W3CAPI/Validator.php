<?php

namespace W3CAPI;

class Validator
{
    protected $client;
    
    protected $doctype;
    protected $charset;
    protected $valid;
    
    protected $errorCount;
    protected $errorList = array();
    
    protected $warningCount;
    protected $warningList = array();
    
    public function __construct(Interfaces\ClientInterface $client = null)
    {
        if(is_null($client)) {
            $client = new Client;
        }
        
        $this->client = $client;
    }
    
    public function validate($url)
    {
        $response = $this->client->sendRequest($url);

        if(!is_array($response)) {
            throw new Exceptions\ValidatorUnknownError;
        }
        
        // 
        
        $this->doctype  = (!empty($response['doctype']))
                            ? $response['doctype']
                            : 'Unknown';
        
        $this->charset  = (!empty($response['charset']))
                            ? $response['charset']
                            : 'Unknown';
        
        $this->valid    = (!empty($response['validity']) && strcasecmp($response['validity'], 'true') === 0)
                            ? true
                            : false;
        
        if(!empty($response['errors'])) {
            $error_info = $response['errors'];
            
            $this->errorCount = (int)$error_info['errorcount'];
            
            if($this->errorCount > 0) {
                foreach($error_info['errorlist'] as $error) {
                    $this->errorList[] = $error;
                }
            }
        }

        if(!empty($response['warnings'])) {
            $warning_info = $response['warnings'];
            
            /*
             * The W3C API itself appears to occasionally return
             * an erroneous warning count - so instead, we'll take
             * a count of the warning list array.
             * 
             */
            
            $this->warningCount = (is_array($warning_info['warninglist']))
                                    ? count($warning_info['warninglist'])
                                    : 0;
            
            if($this->warningCount > 0) {
                foreach($warning_info['warninglist'] as $warning) {
                    $this->warningList[] = $warning;
                }
            }
        }
    }
    
    public function getDoctype()
    {
        return $this->doctype;
    }
    
    public function getCharset()
    {
        return $this->charset;
    }
    
    public function isValid()
    {
        return ($this->valid === true);
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }
    
    public function getErrors()
    {
        return $this->errorList;
    }

    public function getWarningCount()
    {
        return $this->warningCount;
    }
    
    public function getWarnings()
    {
        return $this->warningList;
    }
}