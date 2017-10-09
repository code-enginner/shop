<?php
    session_start();
    ob_start();
    date_default_timezone_set('Asia/Tehran');

    define('root', dirname(__DIR__).DIRECTORY_SEPARATOR);
    define('_base_url',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/');
    define('_base_url_2',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['SCRIPT_NAME'])).'/');
    define('_base_url_3',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))).'/');
    define('KB', 1024);
    define('MB', 1048576);
    define('GB', 1073741824);
    define('TB', 1099511627776);