<?php
/**
 * Class representing an HTTP request message
 *
 * PHP version 5.3
 *
 * @package   Lib2616
 * @author    Chris Wright <info@daverandom.com>
 * @copyright Copyright (c) 2013 Chris Wright
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   1.0
 */
namespace Lib2616;

/**
 * Class representing an HTTP request message
 *
 * @package Lib2616
 * @author  Chris Wright <info@daverandom.com>
 */
class Request extends Message
{
    /**
     * @var string The request method
     */
    protected $method;

    /**
     * @var string The request URI
     */
    protected $uri;

    /**
     * Constructor
     *
     * @param \Lib822\HeaderCollection[] $headers Map of HeaderCollection objects representing the message headers
     * @param string                     $body    The request body
     * @param string                     $version The request protocol version
     * @param string                     $method  The request method
     * @param string                     $uri     The request URI
     */
    public function __construct(array $headers, $body, $version, $method, $uri)
    {
        parent::__construct($headers, $body, $version);
        $this->method  = $method;
        $this->uri     = $uri;
    }

    /**
     * Get the request method
     *
     * @return string The request method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the request URI
     *
     * @return string The request URI
     */
    public function getURI()
    {
        return $this->uri;
    }
}
