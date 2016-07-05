<?php

header('Content-Type: text/html; charset=utf-8');

define('SERVER_NM', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);
define('WEB_ROOT',  'http://'. SERVER_NM .'/');

define('IS_DEV', ((strpos(SERVER_NM, 'localhost') === 0) or (strtolower(SERVER_NM) == 'mikedang')));
define('IS_STG', (strtolower(SERVER_NM) == 'stg.mikedang.com'));

define('APP_INIT', 1);

if (IS_DEV)
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    define('APP_ROOT',    realpath(dirname(__FILE__)));

    define('STATIC_ROOT', '/assets');
    $include_base_path =  realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR .'lib');
}
else if (IS_STG)
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL ^ E_NOTICE);

    define('APP_ROOT',    realpath(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . SERVER_NM);
    define('STATIC_ROOT', 'http://static.mikedang.com/v4');
    $include_base_path =  realpath(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .'lib'. DIRECTORY_SEPARATOR . SERVER_NM);
}
else
{
    ini_set('display_errors', 0);
    error_reporting(0);

    define('APP_ROOT',    realpath(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'mikedang.com');

    define('STATIC_ROOT', '/assets');
    $include_base_path =  realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR .'lib');
    // define('STATIC_ROOT', 'http://static.mikedang.com/v4');
    // $include_base_path =  realpath(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .'lib'. DIRECTORY_SEPARATOR . 'mikedang.com');
}

set_include_path(get_include_path() . PATH_SEPARATOR . $include_base_path);
set_include_path(get_include_path() . PATH_SEPARATOR . $include_base_path . DIRECTORY_SEPARATOR .'classes');
set_include_path(get_include_path() . PATH_SEPARATOR . $include_base_path . DIRECTORY_SEPARATOR .'classes'. DIRECTORY_SEPARATOR .'Zend');
set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT . DIRECTORY_SEPARATOR .'includes');

require_once 'config.php';
require_once 'func.php';

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

/**
 * @see Zend_Db
 */
require_once 'Db.php';

// Set up the lazy database connections
$db = array();

$db_core_params = array(
        'host'     => $db_config[DB_CONN_CORE]['host'],
        'username' => $db_config[DB_CONN_CORE]['user'],
        'password' => $db_config[DB_CONN_CORE]['pswd'],
        'dbname'   => $db_config[DB_CONN_CORE]['database']
    );
$db_wordpress_params = array(
        'host'     => $db_config[DB_CONN_WORDPRESS]['host'],
        'username' => $db_config[DB_CONN_WORDPRESS]['user'],
        'password' => $db_config[DB_CONN_WORDPRESS]['pswd'],
        'dbname'   => $db_config[DB_CONN_WORDPRESS]['database']
    );

$db[DB_CONN_CORE]      = App_Db::factory($db_config[DB_CONN_CORE]['type'], $db_core_params);
$db[DB_CONN_WORDPRESS] = App_Db::factory($db_config[DB_CONN_WORDPRESS]['type'], $db_wordpress_params);

Zend_Registry::set('db', $db);

$debug = array();

$browser_info = get_browser_info();

set_exception_handler('site_exception_handler');
