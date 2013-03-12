<?php
/**
 * Class representing the basic RFC2616 message format
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

use \Lib822\Message as RFC822Message;

/**
 * Class representing the basic RFC2616 message format
 *
 * @package Lib2616
 * @author  Chris Wright <info@daverandom.com>
 */
abstract class Message extends RFC822Message
{
    /**
     * @var string The message protocol version
     */
    protected $version;

    /**
     * Constructor
     *
     * @param \Lib822\HeaderCollection[] $headers Map of HeaderCollection objects representing the message headers
     * @param string                     $body    The message body
     * @param string                     $version The message protocol version
     */
    public function __construct(array $headers, $body, $version)
    {
        parent::__construct($headers, $body);
        $this->version = $version;
    }

    /**
     * Get the message protocol version
     *
     * @return string The message protocol version
     */
    public function getVersion()
    {
        return $this->version;
    }
}
