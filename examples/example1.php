<?php

    use \Lib2616\MessageParserFactory;

    require __DIR__ . '/../src/bootstrap.php';

    $messageParser = (new MessageParserFactory)->create();

    $data = file_get_contents(__DIR__ . '/example1.msg');

    $message = $messageParser->parseRequest($data);
    
    $contentTypeHeader = $message->getHeader('Content-Type');

    echo 'The request method is "', $message->getMethod(), "\"\n",
         'The Content-Type is "', $message->getHeader('Content-Type')->item(0), "\"\n",
         'The message body is "', $message->getBody(), '"';