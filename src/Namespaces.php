<?php

namespace EclipseGc\Plugin;

use Composer\Autoload\ClassLoader;

/**
 * A helper class for extracting namespaces from the composer autoloader.
 */
class Namespaces {

  /**
   * Extracts a list of namespaces and directories from the class loader.
   *
   * @param \Composer\Autoload\ClassLoader $classLoader
   *   The composer classloader object.
   *
   * @return \ArrayIterator
   *   An iterate-able list of namespaces and directories.
   */
  public static function extractNamespaces(ClassLoader $classLoader) {
    $namespaces = [];
    foreach ($classLoader->getPrefixes() as $namespace => $directories) {
      $namespaces[$namespace] = $directories[0];
    }
    foreach ($classLoader->getPrefixesPsr4() as $namespace => $directories) {
      $namespaces[$namespace] = $directories[0];
    }
    return new \ArrayIterator($namespaces);
  }

}
