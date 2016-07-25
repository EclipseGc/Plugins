<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Discovery\StaticPluginDiscovery.
 */

namespace EclipseGc\Plugin\Discovery;

use EclipseGc\Plugin\PluginDefinitionInterface;
use EclipseGc\Plugin\Traits\PluginDiscoveryTrait;

class StaticPluginDiscovery implements StaticPluginDiscoveryInterface {

  use PluginDiscoveryTrait;

  /**
   * {@inheritdoc}
   */
  public function addPluginDefinition(PluginDefinitionInterface $definition) {
    $this->definitions[$definition->getPluginId()] = $definition;
    return $this;
  }

}
