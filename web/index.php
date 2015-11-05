<?php
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__ . '/../var/bootstrap.php.cache';

require_once __DIR__ . '/../src/AppKernel.php';

$environment = array_key_exists('SYMFONY_ENVIRONMENT', $_SERVER) ? $_SERVER['SYMFONY_ENVIRONMENT'] : 'production';
$debug = array_key_exists('SYMFONY_DEBUG', $_SERVER) ? boolval($_SERVER['SYMFONY_DEBUG']) : false;

$kernel = new AppKernel($environment, $debug);
$kernel->loadClassCache();

$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
