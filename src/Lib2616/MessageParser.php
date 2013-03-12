<?php
/**
 * Parser which creates RFC2616 message objects from strings
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

use \Lib822\MessageParser           as RFC822MessageParser,
    \Lib822\HeaderFactory           as RFC822HeaderFactory,
    \Lib822\HeaderCollectionFactory as RFC822HeaderCollectionFactory;

/**
 * Parser which creates RFC2616 message objects from strings
 *
 * @package Lib2616
 * @author  Chris Wright <info@daverandom.com>
 */
class MessageParser extends RFC822MessageParser
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
     *
     * @param \Lib822\HeaderFactory           $headerFactory           Factory which makes Header objects
     * @param \Lib822\HeaderCollectionFactory $headerCollectionFactory Factory which makes HeaderCollection objects
     * @param \Lib2616\RequestFactory         $requestFactory  Factory which makes Request objects
     * @param \Lib2616\ResponseFactory        $responseFactory Factory which makes Response objects
     */
    public function __construct(
        RFC822HeaderFactory $headerFactory,
        RFC822HeaderCollectionFactory $headerCollectionFactory,
        RequestFactory $requestFactory,
        ResponseFactory $responseFactory
    ) {
        $this->headerFactory           = $headerFactory;
        $this->headerCollectionFactory = $headerCollectionFactory;
        $this->requestFactory          = $requestFactory;
        $this->responseFactory         = $responseFactory;
    }

    /**
     * Remove the request line from the message and parse into tokens
     *
     * @param string $head The message head section
     *
     * @return array The parsed request line at index 0, the remainder of the message at index 1
     *
     * @throws \DomainException When the request line of the message is invalid
     */
    private function removeAndParseRequestLine($head)
    {
        $parts = preg_split('/\r?\n/', $head, 2);

        $expr =
          '@^
            (?:
              ([^\r\n \t]+) [ \t]+ ([^\r\n \t]+) [ \t]+ HTTP/(\d+\.\d+) # request
             |
              HTTP/(\d+\.\d+) [ \t]+ (\d+) [ \t]+ ([^\r\n]+)            # response
            )
           $@ix';
        if (!preg_match($expr, $parts[0], $match)) {
            throw new \DomainException('Request-Line of the message is invalid');
        }

        if (empty($match[4])) { // request
            $requestLine = array(
                'method'  => strtoupper($match[1]),
                'uri'     => $match[2],
                'version' => $match[3]
            );
        } else { // response
            $requestLine = array(
                'version' => $match[4],
                'code'    => (int) $match[5],
                'message' => $match[6]
            );
        }

        return array(
            $requestLine,
            isset($parts[1]) ? $parts[1] : ''
        );
    }

    /**
     * Create the appropriate Message object from a string
     *
     * @param string $message The message string
     *
     * @return Request|Response The parsed Message object
     *
     * @throws \DomainException When the message string is not valid HTTP message
     */
    public function parseMessage($message)
    {
        list($head, $body) = $this->splitHeadFromBody($message);
        list($requestLine, $head) = $this->removeAndParseRequestLine($head);
        $headers = $this->parseHeaders($head);

        if (isset($requestLine['uri'])) {
            return $this->requestFactory->create(
                $headers,
                $body,
                $requestLine['version'],
                $requestLine['method'],
                $requestLine['uri']
            );
        } else {
            return $this->responseFactory->create(
                $headers,
                $body,
                $requestLine['version'],
                $requestLine['code'],
                $requestLine['message']
            );
        }
    }

    /**
     * Create a Request object from a string
     *
     * @param string $message The request string
     *
     * @return Request|Response The parsed Request object
     *
     * @throws \DomainException When the message string is not valid HTTP request message
     */
    public function parseRequest($message)
    {
        list($head, $body) = $this->splitHeadFromBody($message);
        list($requestLine, $head) = $this->removeAndParseRequestLine($head);

        if (!isset($requestLine['uri'])) {
            throw new \DomainException('Message is not a valid HTTP request');
        }

        $headers = $this->parseHeaders($head);

        return $this->requestFactory->create(
            $headers,
            $body,
            $requestLine['version'],
            $requestLine['method'],
            $requestLine['uri']
        );
    }

    /**
     * Create a Response object from a string
     *
     * @param string $message The response string
     *
     * @return Request|Response The parsed Response object
     *
     * @throws \DomainException When the message string is not valid HTTP response message
     */
    public function parseResponse($message)
    {
        list($head, $body) = $this->splitHeadFromBody($message);
        list($requestLine, $head) = $this->removeAndParseRequestLine($head);

        if (isset($requestLine['uri'])) {
            throw new \DomainException('Message is not a valid HTTP response');
        }

        $headers = $this->parseHeaders($head);

        return $this->responseFactory->create(
            $headers,
            $body,
            $requestLine['version'],
            $requestLine['code'],
            $requestLine['message']
        );
    }
}
