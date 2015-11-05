<?php
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__ . '/../var/vendor/autoload.php';
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
