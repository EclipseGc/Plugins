<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Factory\TestPluginFactory.
 */

namespace EclipseGc\Plugin\Test\Factory;

use EclipseGc\Plugin\Factory\FactoryInterface;
use EclipseGc\Plugin\PluginDefinitionInterface;

class TestPluginFactory implements FactoryInterface {

  public function createInstance(PluginDefinitionInterface $definition, ...$constructors) {
    $class = $definition->getClass();
    return new $class(...$constructors);
  }

}
