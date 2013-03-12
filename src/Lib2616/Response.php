<?php
/**
 * Class representing an HTTP response message
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
 * Class representing an HTTP response message
 *
 * @package Lib2616
 * @author  Chris Wright <info@daverandom.com>
 */
class Response extends Message
{
    /**
     * @var int The response code
     */
    protected $code;

    /**
     * @var string The response message
     */
    protected $message;

    /**
     * Constructor
     *
     * @param \Lib822\HeaderCollection[] $headers Map of HeaderCollection objects representing the message headers
     * @param string                     $body    The request body
     * @param string                     $version The request protocol version
     * @param int                        $code    The response code
     * @param string                     $message The response message
     */
    public function __construct(array $headers, $body, $version, $code, $message)
    {
        parent::__construct($headers, $body, $version);
        $this->code    = $code;
        $this->message = $message;
    }

    /**
     * Get the response code
     *
     * @return int The response code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the response message
     *
     * @return string The response message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
