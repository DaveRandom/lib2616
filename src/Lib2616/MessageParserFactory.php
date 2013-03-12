<?php
/**
 * Factory which makes MessageParser objects
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

use \Lib822\MessageParserFactory as RFC822MessageParserFactory;

/**
 * Factory which makes MessageParser objects
 *
 * @package Lib2616
 * @author  Chris Wright <info@daverandom.com>
 */
class MessageParserFactory extends RFC822MessageParserFactory
{
    /**
     * @var \Lib2616\RequestFactory Factory which makes Request objects
     */
    private $requestFactory;

    /**
     * @var \Lib2616\ResponseFactory Factory which makes Response objects
     */
    private $responseFactory;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->requestFactory = new RequestFactory;
        $this->responseFactory = new ResponseFactory;
    }

    /**
     * Create a new MessageParser object
     *
     * @return \Lib822\MessageParser The created Header object
     */
    public function create()
    {
        return new MessageParser(
            $this->headerFactory,
            $this->headerCollectionFactory,
            $this->requestFactory,
            $this->responseFactory
        );
    }
}
