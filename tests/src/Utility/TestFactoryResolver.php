<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Utility\TestFactoryResolver.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Factory\FactoryInterface;
use EclipseGc\Plugin\Factory\FactoryResolverInterface;

class TestFactoryResolver implements FactoryResolverInterface {

  public function getFactoryInstance(string $factoryClass) : FactoryInterface {
    return new $factoryClass();
  }

}
