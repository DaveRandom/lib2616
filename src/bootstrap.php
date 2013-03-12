<?php
/**
 * Bootstrap for the Lib2616 library
 *
 * PHP version 5.3
 *
 * @package   Lib2616
 * @author    Chris Wright <info@daverandom.com>
 * @copyright Copyright (c) 2013 Chris Wright
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   1.0
 */

call_user_func(function() {
    $classMap = array(
        'lib2616\message'              => __DIR__ . '/Lib2616/Message.php',
        'lib2616\messageparser'        => __DIR__ . '/Lib2616/MessageParser.php',
        'lib2616\messageparserfactory' => __DIR__ . '/Lib2616/MessageParserFactory.php',
        'lib2616\request'              => __DIR__ . '/Lib2616/Request.php',
        'lib2616\requestfactory'       => __DIR__ . '/Lib2616/RequestFactory.php',
        'lib2616\response'             => __DIR__ . '/Lib2616/Response.php',
        'lib2616\responsefactory'      => __DIR__ . '/Lib2616/ResponseFactory.php',
    );

    if (function_exists('__autoload') && !in_array('__autoload', spl_autoload_functions())) {
       spl_autoload_register('__autoload');
    }

    spl_autoload_register(function($className) use($classMap) {
        $className = strtolower($className);

        if (isset($classMap[$className])) {
            require $classMap[$className];
        }
    });
});

require_once __DIR__ . '/Lib822/src/bootstrap.php';
