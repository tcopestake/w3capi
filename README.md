w3capi
======

A PHP wrapper/client for the W3C validator API

Quick disclaimer
----------------

I'm unsure how stable the actual W3C API is, as it's documented as experimental and subject to change; don't be surprised if things stop working. You can read more at [http://validator.w3.org/docs/api.html](http://validator.w3.org/docs/api.html)

Pay special attention to this notice:

> If you wish to call the validator programmatically for a batch of documents,
> please make sure that your script will sleep for **at least 1 second** between requests.
> The Markup Validation service is a free, public service for all, your respect is appreciated. thanks.

When making multiple calls through a validator instance, this will be done for you (see below).

Requirements:
-------------

* PHP 5.3+
* \* cURL
* \* SimpleXML

\* Can be abstracted away by providing alternative interfaces

Installation
------------

This package can be installed manually or via Composer.

### Composer

Add the following to your project's composer.json:

    "repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/tcopestake/w3capi"
        }
    ],

and:

    "require": {
        "tcopestake/w3capi": "*"
    },

### Manual

Download and extract the files.

If your project doesn't already have a suitable autoloader, you can use the one provided by including src/bootstrap.php:

    include('path/to/src/bootstrap.php');

Usage
-----

### The validator

To validate a document:

    $validator = new \W3CAPI\Validator;

    try {
        $validator->validate('http://url.test.com/a-html-page');
    } catch(\W3CAPI\Exceptions\SoapClientBadResponse $e) {
        echo "Most likely, W3C reported a server error.";
    } catch(\W3CAPI\ValidatorUnknownError $e) {
        echo "Something went wrong, but we don't know what.";
    }

If successful, information can then be retrieved from the instance, such as whether the document passed validation:

    echo ($validator->isValid()) ? 'Valid' : 'Invalid';

and information about semantic validation errors:

    if($validator->getErrorCount() > 0) {
        foreach($validator->getErrors() as $error) {
            /*
             * $error will be an array
             * containing the error message, etc.
             *
             */
        }
    }

and information about validation warnings:

    if($validator->getWarningCount() > 0) {
        foreach($validator->getWarnings() as $warning) {
            /*
             * $warning will be an array
             * containing the warning message, etc.
             *
             */
        }
    }

If you wish to validate another document, the validator instance can be easily reused:

    try {
        $validator->validate('http://another.url.com/shame.css');
    } catch(\W3CAPI\Exceptions\SoapClientBadResponse $e) {
        echo "Most likely, W3C reported a server error.";
    } catch(\W3CAPI\ValidatorUnknownError $e) {
        echo "Something went wrong, but we don't know what.";
    }

Note that when making subsequent calls, the validator class will enforce W3C's "1 second" rule by delaying sending the request if necessary.

Tests
-----

There are unit tests.

Possible developments(?)
------------------------

* Support for validating documents via POST upload.
* More documentation (esp. on dependency injection).
* Revisit the XML parser.
* More transparency between classes e.g. ability to retrieve HTTP headers
* Peer pressure is forcing me to switch to PSR-2, but my muscle memory forgets this sometimes.