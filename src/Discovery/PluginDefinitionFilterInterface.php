<?php

/**
 * @file
 * Contains \EclipseGc\Plugin\Discovery\PluginDefinitionFilterINterface.
 */

namespace EclipseGc\Plugin\Discovery;

interface PluginDefinitionFilterInterface {

  /**
   * Filters available plugins in the plugin discovery object.
   *
   * @param \EclipseGc\Plugin\PluginDefinitionInterface[] $definitions
   *
   * @return \EclipseGc\Plugin\PluginDefinitionInterface[]
   */
  public function filter(array $definitions);

}
