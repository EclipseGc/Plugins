<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Test\Utility\TestDeriverResolver.
 */

namespace EclipseGc\Plugin\Test\Utility;

use EclipseGc\Plugin\Derivative\PluginDeriverInterface;
use EclipseGc\Plugin\Derivative\PluginDeriverResolverInterface;

class TestDeriverResolver implements PluginDeriverResolverInterface {

  public function getDeriverInstance(string $resolverClass) : PluginDeriverInterface {
    return new $resolverClass();
  }

}
