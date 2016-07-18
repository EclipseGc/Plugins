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
   * @param \EclipseGc\Plugin\PluginDefinitionInterface $definition
   *
   * @return bool
   */
  public function filter(PluginDefinitionInterface $definition);

}
