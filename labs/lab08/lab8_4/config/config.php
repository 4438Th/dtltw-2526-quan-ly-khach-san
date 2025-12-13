<?php
// Use central database configuration if available
$centralDb = realpath(__DIR__ . '/../../../../configs/database.php');
if ($centralDb && file_exists($centralDb)) {
    require_once $centralDb;
    // Map old constants for backward compatibility
    if (!defined('HOST')) define('HOST', DB_HOST);
    if (!defined('DB_NAME')) define('DB_NAME', DB_NAME);
    if (!defined('DB_USER')) define('DB_USER', DB_USER);
    if (!defined('DB_PASS')) define('DB_PASS', DB_PASS);
} else {
    // Fallback (original local config)
    $configDB = array();
    $configDB["host"] = "localhost";
    $configDB["database"] = "bookstore";
    $configDB["username"] = "root";
    $configDB["password"] = "";
    if (!defined('HOST')) define('HOST', 'localhost');
    if (!defined('DB_NAME')) define('DB_NAME', 'bookstore');
    if (!defined('DB_USER')) define('DB_USER', 'root');
    if (!defined('DB_PASS')) define('DB_PASS', '');
}
define('ROOT', dirname(dirname(__FILE__)));
// Thu muc tuyet doi truoc cua config; c:/wamp/www/lab/
if (!defined('BASE_URL')) define('BASE_URL', "http://" . $_SERVER['SERVER_NAME'] . "/lab/"); // dia chi website
