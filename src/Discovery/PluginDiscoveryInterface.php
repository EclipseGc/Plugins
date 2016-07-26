<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Discovery\PluginDiscoveryInterface.
 */

namespace EclipseGc\Plugin\Discovery;

use EclipseGc\Plugin\PluginDefinitionInterface;

interface PluginDiscoveryInterface {

  /**
   * Finds plugins via a particular discovery pattern.
   *
   * Plugin discovery classes can provide a multitude of different options for
   * finding plugin implementations. This could be implemented via yaml files,
   * class annotations, php functions or numerous other solutions. Each
   * discovery class is different and will have different parameters for
   * finding plugins.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface[] $definitions
   *   A list of known definitions to add to the set.
   *
   * @return \EclipseGc\Plugin\Discovery\PluginDefinitionSet
   */
  public function findPluginImplementations(PluginDefinitionInterface ...$definitions) : PluginDefinitionSet;

}
