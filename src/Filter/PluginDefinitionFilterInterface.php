<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Discovery\PluginDefinitionFilterInterface.
 */

namespace EclipseGc\Plugin\Filter;

use EclipseGc\Plugin\PluginDefinitionInterface;

interface PluginDefinitionFilterInterface {

  /**
   * Filters available plugins in the plugin discovery object.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface[] $definitions
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  public function filter(PluginDefinitionInterface ...$definitions);

}
