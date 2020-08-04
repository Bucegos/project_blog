<?php
// The server/domain name
define('HOST', 'http://blog.local/');
// Database info
define('DATABASE_SERVERNAME', 'localhost');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', 'K!illerH!ills007');
define('DATABASE_NAME', 'blog');
// App directory path
define('APP_ROOT', dirname(__DIR__, 1));
// Public directory path
define('APP_PUBLIC', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public');
// Assets paths
define('ASSETS', APP_PUBLIC . DIRECTORY_SEPARATOR . 'assets');
define('UPLOADS', ASSETS . DIRECTORY_SEPARATOR . 'uploads');
// Default controller and method
define('DEFAULT_CONTROLLER', 'App\Controller\HomeController');
define('DEFAULT_METHOD', 'index');
// Classes paths for autoload
define('CORE', APP_ROOT . DIRECTORY_SEPARATOR . 'core');
define('CONTROLLERS', APP_ROOT . DIRECTORY_SEPARATOR . 'controllers');
define('MODELS', APP_ROOT . DIRECTORY_SEPARATOR . 'models');
define('HELPERS', APP_ROOT . DIRECTORY_SEPARATOR . 'helpers');
// Templates and elements paths
define('TEMPLATES', APP_ROOT . DIRECTORY_SEPARATOR . 'templates');
define('ELEMENTS', APP_ROOT . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'elements');
// Log files paths
define('LOGS', APP_ROOT . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'logs');
// Autoload classes array
define('AUTOLOAD_CLASSES', [CONTROLLERS, MODELS, HELPERS, CORE]);
// Namespaces
define('CONTROLLERS_NAMESPACE', 'App\Controller\\');
define('MODELS_NAMESPACE', 'App\Model\\');
define('HELPERS_NAMESPACE', 'App\Helper\\');
