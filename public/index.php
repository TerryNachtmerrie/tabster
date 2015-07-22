<?php
/**
 * Terry's MVC entrance
 */
use Tabster\Application\Application;
use Tabster\Application\Config\Config;
use Tabster\Application\Config\ConfigCollection;
use Tabster\Application\Database\Database;
use Tabster\Application\Session\Session;
use Tabster\Models\Users;
use AltoRouter as Router;

define('APP_PATH', realpath('..'));
define('ENVIRONMENT', 'debug');

if(ENVIRONMENT == 'debug'){
    error_reporting(E_ALL);
}

// Autoloaders
require APP_PATH . '/app/Autoloader.php';

$autoloader = new Tabster\Autoloader();
$autoloader->register();
$autoloader->addNamespace('Tabster', APP_PATH . '/app');

require APP_PATH . '/vendor/autoload.php';

$config = new ConfigCollection();
$config->addConfig(new Config(APP_PATH . '/app/config/database.php', Config::CONFIG_ARRAY));
$config->addConfig(new Config(APP_PATH . '/app/config/cookie.php', Config::CONFIG_ARRAY));
$config->addConfig(new Config(APP_PATH . '/app/config/routes.php', Config::CONFIG_ARRAY));
$config->addConfig(new Config(APP_PATH . '/app/config/view.php', Config::CONFIG_ARRAY));

try {
    $application = new Application($config);
    $application->run();
} catch(Exception $e) {
    echo $e->getMessage();
}