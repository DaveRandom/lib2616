<?php
/**
 * Factory which makes Request objects
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

use \Lib822\MessageFactory as RFC822MessageFactory;

/**
 * Factory which makes Request objects
 *
 * @package Lib2616
 * @author  Chris Wright <info@daverandom.com>
 */
class RequestFactory extends RFC822MessageFactory
{
    /**
     * Create a new Request object
     *
     * The last 3 arguments of this method are only optional  to prevent PHP from triggering
     * an E_STRICT at compile time. IMO this particular error is itself an error on the part
     * of the PHP designers,  and I don't feel bad  about about this workaround,  even if it
     * does mean the signature is technically wrong. It is the lesser of two evils.
     *
     * @param \Lib822\HeaderCollection[] $headers Map of HeaderCollection objects representing the message headers
     * @param string                     $body    The request body
     * @param string                     $version The request protocol version
     * @param string                     $method  The request method
     * @param string                     $uri     The request URI
     */
    public function create(array $headers, $body, $version = null, $method = null, $uri = null)
    {
        return new Request($headers, $body, $version, $method, $uri);
    }
}
